<?php

declare(strict_types=1);

namespace Enabel\LayoutBundle\Controller\Favicon;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Asset\Packages;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class WebmanifestAction extends AbstractController
{
    #[Route(
        path: '/favicon/site.webmanifest',
        name: 'enabel_layout_favicon_webmanifest',
        defaults: [
            '_format' => 'json',
        ],
        methods: 'GET'
    )]
    public function __invoke(ParameterBagInterface $parameterBag, Packages $assetPackage): Response
    {
        // Not return directly the json response, but render a template [for translation].
        return $this->render('@EnabelLayout/favicon/site.webmanifest.json.twig', [
            'manifest' => [
                'name' => $parameterBag->get('enabel_layout.application_name'),
                'short_name' => $parameterBag->get('enabel_layout.application_short_name'),
                'description' => $parameterBag->get('enabel_layout.application_description'),
                'icon' => $assetPackage->getUrl('bundles/enabellayout/favicon/android-chrome-192x192.png'),
                'url' => $this->generateUrl('homepage', [], UrlGeneratorInterface::ABSOLUTE_URL),
            ],
        ]);
    }
}
