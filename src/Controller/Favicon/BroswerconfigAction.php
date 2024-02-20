<?php

declare(strict_types=1);

namespace Enabel\LayoutBundle\Controller\Favicon;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BroswerconfigAction extends AbstractController
{
    #[Route(
        path: '/favicon/browserconfig.xml',
        name: 'enabel_layout_favicon_browserconfig',
        defaults: [
            '_format' => 'xml',
        ],
        methods: 'GET'
    )]
    public function __invoke(): Response
    {
        return $this->render('@EnabelLayout/favicon/browserconfig.xml.twig');
    }
}
