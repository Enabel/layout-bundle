<?php

namespace Enabel\LayoutBundle\Tests\Controller\Favicon;

use SimpleXMLElement;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\RouterInterface;

class BrowserconfigActionTest extends WebTestCase
{
    private static KernelBrowser $client;

    protected function setUp(): void
    {
        self::$client = self::createClient();
    }

    public function testBrowserconfigRouteName(): void
    {
        /** @var RouterInterface $router */
        $router = static::getContainer()->get(RouterInterface::class);
        self::$client->request('GET', $router->generate('enabel_layout_favicon_browserconfig'));
        self::assertResponseIsSuccessful();
    }

    public function testBrowserconfigRouteUri(): void
    {
        self::$client->request('GET', '/favicon/browserconfig.xml');
        self::assertResponseIsSuccessful();
    }

    /**
     * @throws \JsonException
     */
    public function testBrowserconfigRouteReturnValidXml(): void
    {
        self::$client->request('GET', '/favicon/browserconfig.xml');
        self::assertResponseIsSuccessful();
        self::assertResponseFormatSame('xml');
        $response = self::$client->getResponse();
        /** @var string $xmlAsString */
        $xmlAsString = $response->getContent();
        /** @var SimpleXMLElement $xml */
        $xml = simplexml_load_string($xmlAsString);
        /** @var string $json */
        $json = json_encode((array)$xml, JSON_THROW_ON_ERROR);
        $array = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        $array = array($xml->getName() => $array);
        self::assertArrayHasKey('browserconfig', $array);
        self::assertIsArray($array['browserconfig']);
        self::assertArrayHasKey('msapplication', $array['browserconfig']);
        self::assertArrayHasKey('tile', $array['browserconfig']['msapplication']);
        self::assertArrayHasKey('square150x150logo', $array['browserconfig']['msapplication']['tile']);
        self::assertArrayHasKey('TileColor', $array['browserconfig']['msapplication']['tile']);
    }
}
