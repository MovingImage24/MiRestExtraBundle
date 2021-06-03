<?php

namespace Mi\Bundle\RestExtraBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 *
 * @codeCoverageIgnore
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @inheritdoc
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('mi_rest_extra');
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
