<?php

declare(strict_types=1);

namespace Enabel\LayoutBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('enabel_layout');
        /** @var ArrayNodeDefinition $rootNode */
        $rootNode = $treeBuilder->getRootNode();

        /** @var NodeBuilder $parentNode */
        $parentNode = $rootNode->children();
        $parentNode
            ->scalarNode('application_name')
            ->defaultValue('Enabel Symfony Application')
            ->end();
        $parentNode
            ->scalarNode('application_short_name')
            ->defaultValue('EnabelSfApp')
            ->end();
        $parentNode
            ->scalarNode('application_description')
            ->defaultValue('Another Symfony application made by Enabel')
            ->end();
        $parentNode
            ->scalarNode('supported_locales')
            ->defaultValue('fr|en')
            ->end();

        return $treeBuilder;
    }
}
