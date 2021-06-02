<?php

namespace Mi\Bundle\RestExtraBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Mi\Bundle\RestExtraBundle\DependencyInjection\MiRestExtraExtension;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 *
 * @covers MiRestExtraExtension
 */
class MiRestExtraExtensionTest extends AbstractExtensionTestCase
{
    /**
     * @test
     */
    public function loadAllListener()
    {
        $this->load();

        $this->assertContainerBuilderHasService('mi.rest_extra_bundle.event_listener.violations');
        $this->assertContainerBuilderHasService('mi.rest_extra_bundle.event_listener.param_fetcher');
        $this->assertContainerBuilderHasService('mi.rest_extra_bundle.event_listener.param_converter');
        $this->assertContainerBuilderHasService('mi.rest_extra_bundle.event_listener.view');
    }

    /**
     * @param string $configType
     * @param string $serviceId
     *
     * @test
     * @dataProvider getListenerConfig
     */
    public function disableListener($configType, $serviceId)
    {
        $this->load([$configType => false]);

        $this->assertContainerBuilderNotHasService($serviceId);
    }

    public function getListenerConfig()
    {
        return [
            ['violations_listener', 'mi.rest_extra_bundle.event_listener.violations'],
            ['param_fetcher_listener', 'mi.rest_extra_bundle.event_listener.param_fetcher'],
            ['param_converter_listener', 'mi.rest_extra_bundle.event_listener.param_converter'],
            ['view_listener', 'mi.rest_extra_bundle.event_listener.view'],
        ];
    }

    protected function getContainerExtensions(): array
    {
        return [new MiRestExtraExtension()];
    }
}
