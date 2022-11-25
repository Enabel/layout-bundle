<?php

namespace Enabel\LayoutBundle\Tests\Controller;

use Enabel\LayoutBundle\Controller\FaviconController;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\RouterInterface;

class FaviconControllerTest extends WebTestCase
{
    private static KernelBrowser $client;

    protected function setUp(): void
    {
        self::$client = self::createClient();
    }

    public function testWebmanifestRouteName(): void
    {
        /** @var RouterInterface $router */
        $router = static::getContainer()->get(RouterInterface::class);
        self::$client->request('GET', $router->generate('enabel_layout_favicon_webmanifest'));
        self::assertResponseIsSuccessful();
    }

    public function testWebmanifestRouteUri(): void
    {
        self::$client->request('GET', '/favicon/site.webmanifest');
        self::assertResponseIsSuccessful();
    }

    public function testWebmanifestRouteReturnValidJson(): void
    {
        $crawler = self::$client->request('GET', '/favicon/site.webmanifest');
        self::assertResponseIsSuccessful();
        self::assertResponseFormatSame('json');
        $response = self::$client->getResponse();
        /** @var string $json */
        $json = $response->getContent();
        /** @var array<string,mixed> $data */
        $data = json_decode($json, true);
        self::assertArrayHasKey('name', $data);
        self::assertArrayHasKey('short_name', $data);
        self::assertArrayHasKey('icons', $data);
        self::assertArrayHasKey('theme_color', $data);
        self::assertArrayHasKey('background_color', $data);
        self::assertArrayHasKey('display', $data);
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

    public function testBrowserconfigRouteReturnValidXml(): void
    {
        $crawler = self::$client->request('GET', '/favicon/browserconfig.xml');
        self::assertResponseIsSuccessful();
        self::assertResponseFormatSame('xml');
        $response = self::$client->getResponse();
        /** @var string $xmlAsString */
        $xmlAsString = $response->getContent();
        /** @var SimpleXMLElement $xml */
        $xml = simplexml_load_string($xmlAsString);
        /** @var string $json */
        $json = json_encode((array) $xml);
        $array = json_decode($json, true);
        $array = array($xml->getName() => $array);
        self::assertArrayHasKey('browserconfig', $array);
        self::assertArrayHasKey('msapplication', $array['browserconfig']);
        self::assertArrayHasKey('tile', $array['browserconfig']['msapplication']);
        self::assertArrayHasKey('square150x150logo', $array['browserconfig']['msapplication']['tile']);
        self::assertArrayHasKey('TileColor', $array['browserconfig']['msapplication']['tile']);
    }
}
