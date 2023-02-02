<?php

declare(strict_types=1);

namespace Enabel\LayoutBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class LayoutBundleExtension extends Extension implements PrependExtensionInterface
{
    /**
     * @param array<string, mixed> $configs
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        foreach ($config as $key => $value) {
            $container->setParameter('enabel_layout.' . $key, $value);
        }
        $loader = new YamlFileLoader($container, new FileLocator(dirname(__DIR__, 2) . '/config'));
        $loader->load('services.yaml');
    }

    public function prepend(ContainerBuilder $container): void
    {
        $configs = $container->getExtensionConfig($this->getAlias());
        $configuration = $this->getConfiguration($configs, $container);
        if (null !== $configuration) {
            $config = $this->processConfiguration($configuration, $configs);
            $container->prependExtensionConfig('enabel_layout', $config);

            $twigConfig = [
                'form_themes' => ['bootstrap_5_layout.html.twig'],
                'paths' => ['public/bundles/enabellayout/images' => 'EnabelLayoutImages']
            ];

            $twigConfig['globals']['enabel_layout'] = [];
            foreach ($config as $k => $v) {
                $twigConfig['globals']['enabel_layout'][$k] = $v;
            }

            $container->prependExtensionConfig('twig', $twigConfig);
        }
    }

    public function getAlias(): string
    {
        return 'enabel_layout';
    }
}
