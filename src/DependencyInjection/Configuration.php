<?php

namespace Mi\Bundle\RestExtraBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('mi_rest_extra', 'array');

        $treeBuilder
            ->getRootNode()
            ->children()
            ->scalarNode('param_fetcher_listener')->defaultTrue()->end()
            ->scalarNode('param_converter_listener')->defaultTrue()->end()
            ->scalarNode('view_listener')->defaultTrue()->end()
            ->scalarNode('violations_listener')->defaultTrue()->end()
            ->scalarNode('security_listener')->defaultFalse()->end()
            ->end();

        return $treeBuilder;
    }
}
