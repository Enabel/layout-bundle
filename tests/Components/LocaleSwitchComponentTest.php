<?php

namespace Enabel\LayoutBundle\Tests\Components;

use Enabel\LayoutBundle\Components\LocaleSwitchComponent;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LocaleSwitchComponentTest extends TestCase
{
    private RequestStack $requestStack;
    private UrlGeneratorInterface $urlGenerator;
    private LocaleSwitchComponent $component;
    private Request $request;

    protected function setUp(): void
    {
        $this->requestStack = $this->createMock(RequestStack::class);
        $this->urlGenerator = $this->createMock(UrlGeneratorInterface::class);
        $this->component = new LocaleSwitchComponent($this->requestStack, $this->urlGenerator);
        $this->request = $this->createMock(Request::class);
        $this->request->attributes = new ParameterBag();
    }

    public function testSwitchUsesCurrentRoute(): void
    {
        // Setup request mock
        $this->request->attributes->set('_route', 'app_home');
        $this->request->attributes->set('_route_params', ['param' => 'value']);

        $this->requestStack->expects($this->once())
            ->method('getCurrentRequest')
            ->willReturn($this->request);

        // Assert URL generator is called with expected parameters
        $this->urlGenerator->expects($this->once())
            ->method('generate')
            ->with(
                'app_home',
                ['param' => 'value', '_locale' => 'fr'],
                UrlGeneratorInterface::ABSOLUTE_PATH
            )
            ->willReturn('/fr/home');

        $result = $this->component->switch('fr');
        $this->assertEquals('/fr/home', $result);
    }

    public function testSwitchUsesSpecificLocaleRoute(): void
    {
        // Setup request mock with locale switch route
        $this->request->attributes->set('_locale_switch_route', 'app_special');
        $this->request->attributes->set('_locale_switch_params', ['special' => 'param']);

        $this->requestStack->expects($this->once())
            ->method('getCurrentRequest')
            ->willReturn($this->request);

        // Assert URL generator is called with expected parameters
        $this->urlGenerator->expects($this->once())
            ->method('generate')
            ->with(
                'app_special',
                ['special' => 'param', '_locale' => 'en'],
                UrlGeneratorInterface::ABSOLUTE_PATH
            )
            ->willReturn('/en/special');

        $result = $this->component->switch('en');
        $this->assertEquals('/en/special', $result);
    }

    public function testSwitchWithCustomReferenceType(): void
    {
        // Setup request mock
        $this->request->attributes->set('_route', 'app_home');
        $this->request->attributes->set('_route_params', []);

        $this->requestStack->expects($this->once())
            ->method('getCurrentRequest')
            ->willReturn($this->request);

        // Assert URL generator is called with expected parameters
        $this->urlGenerator->expects($this->once())
            ->method('generate')
            ->with(
                'app_home',
                ['_locale' => 'fr'],
                UrlGeneratorInterface::ABSOLUTE_URL
            )
            ->willReturn('https://example.com/fr/home');

        $result = $this->component->switch('fr', UrlGeneratorInterface::ABSOLUTE_URL);
        $this->assertEquals('https://example.com/fr/home', $result);
    }

    public function testSwitchWithNoRequestThrowsException(): void
    {
        $this->requestStack->expects($this->once())
            ->method('getCurrentRequest')
            ->willReturn(null);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('No request found in RequestStack when trying to switch locale');

        $this->component->switch('fr');
    }
}
