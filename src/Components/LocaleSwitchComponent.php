<?php

declare(strict_types=1);

namespace Enabel\LayoutBundle\Components;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('locale-switch', '@EnabelLayout/components/locale-switch.html.twig')]
class LocaleSwitchComponent
{
    public function __construct(private RequestStack $requestStack, private UrlGeneratorInterface $urlGenerator)
    {
    }

    public function switch(string $locale, int $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH): string
    {
        $request = $this->requestStack->getCurrentRequest();

        if (!$request instanceof Request) {
            throw new \RuntimeException('No request found in RequestStack when trying to switch locale. Make sure you are calling this from a request context.');
        }

        $route = $request->attributes->get('_locale_switch_route', $request->attributes->get('_route'));
        $params = $request->attributes->get('_locale_switch_params', $request->attributes->get('_route_params'));
        $params['_locale'] = $locale;

        return $this->urlGenerator->generate($route, $params, $referenceType);
    }
}
