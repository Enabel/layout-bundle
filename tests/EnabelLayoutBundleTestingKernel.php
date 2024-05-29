<?php

namespace Enabel\LayoutBundle\Tests;

use Enabel\LayoutBundle\EnabelLayoutBundle;
use Psr\Log\NullLogger;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class EnabelLayoutBundleTestingKernel extends Kernel
{
    use MicroKernelTrait;

    public function registerBundles(): iterable
    {
        yield new FrameworkBundle();
        yield new TwigBundle();
        yield new EnabelLayoutBundle();
    }

    private function configureContainer(
        ContainerConfigurator $container,
        LoaderInterface $loader,
        ContainerBuilder $builder
    ): void {

        // Create directories (IRL: created with flex)
        $filesystem = new Filesystem();
        $filesystem->mkdir(
            Path::normalize('public/bundles/enabellayout/images'),
        );
        $filesystem->mkdir(
            Path::normalize('public/bundles/enabellayout/favicon'),
        );

        $container->extension('framework', [
            'secret' => 'S3CRET',
            'test'   => true,
            'http_method_override' => false,
            'handle_all_throwables' => true,
            'php_errors' => [
                'log' => true,
                'throw' => true,
            ],
        ]);
        $container->services()->set('logger', NullLogger::class);
    }

    private function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import(__DIR__ . '/../config/routes.yaml');
        $routes->add('homepage', 'https://google.be');
    }
}
