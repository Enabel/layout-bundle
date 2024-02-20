<?php

namespace Enabel\LayoutBundle\Tests\Controller\Favicon;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\RouterInterface;

class WebmanifestActionTest extends WebTestCase
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

    /**
     * @throws \JsonException
     */
    public function testWebmanifestRouteReturnValidJson(): void
    {
        self::$client->request('GET', '/favicon/site.webmanifest');
        self::assertResponseIsSuccessful();
        self::assertResponseFormatSame('json');
        $response = self::$client->getResponse();
        /** @var string $json */
        $json = $response->getContent();
        /** @var array<string,mixed> $data */
        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        self::assertArrayHasKey('name', $data);
        self::assertArrayHasKey('short_name', $data);
        self::assertArrayHasKey('icons', $data);
        self::assertArrayHasKey('theme_color', $data);
        self::assertArrayHasKey('background_color', $data);
        self::assertArrayHasKey('display', $data);
    }
}
