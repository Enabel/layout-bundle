<?php

declare(strict_types=1);

namespace Enabel\LayoutBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Asset\Packages;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route(path: '/favicon', name: 'enabel_layout_favicon_')]
class FaviconController extends AbstractController
{
    #[Route(
        path: '/site.webmanifest',
        name: 'webmanifest',
        methods: 'GET',
        defaults: [
            '_format' => 'json',
        ]
    )]
    public function webmanifest(ParameterBagInterface $parameterBag, Packages $assetPackage): Response
    {
        return new JsonResponse([
            'name' => $parameterBag->get('enabel_layout.application_name'),
            'short_name' => $parameterBag->get('enabel_layout.application_short_name'),
            'icons' => [
                [
                    'src' => $assetPackage->getUrl('bundles/enabellayout/favicon/android-chrome-192x192.png'),
                    'sizes' => '192x192',
                    'type' => 'image/png',
                ],
            ],
            'theme_color' => '#ffffff',
            'background_color' => '#ffffff',
            'start_url' => $this->generateUrl('homepage', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'display' => 'standalone',
        ]);
    }

    #[Route(
        path: '/browserconfig.xml',
        name: 'browserconfig',
        methods: 'GET',
        defaults: [
            '_format' => 'xml',
        ]
    )]
    public function browserconfig(): Response
    {
        return $this->render('@EnabelLayout/favicon/browserconfig.xml.twig');
    }
}
