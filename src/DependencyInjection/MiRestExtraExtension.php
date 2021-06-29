<?php

declare(strict_types=1);

namespace Mi\Bundle\RestExtraBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 *
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 */
class MiRestExtraExtension extends ConfigurableExtension
{
    /**
     * @inheritdoc
     */
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $loader->load('event_listener.xml');

        if ($mergedConfig['violations_listener'] === false) {
            $container->removeDefinition('mi.rest_extra_bundle.event_listener.violations');
        }

        if ($mergedConfig['param_fetcher_listener'] === false) {
            $container->removeDefinition('mi.rest_extra_bundle.event_listener.param_fetcher');
        }

        if ($mergedConfig['param_converter_listener'] === false) {
            $container->removeDefinition('mi.rest_extra_bundle.event_listener.param_converter');
        }

        if ($mergedConfig['view_listener'] === false) {
            $container->removeDefinition('mi.rest_extra_bundle.event_listener.view');
        }

        if ($mergedConfig['security_listener'] === false) {
            $container->removeDefinition('mi.rest_extra_bundle.event_listener.security');
        }
    }
}
