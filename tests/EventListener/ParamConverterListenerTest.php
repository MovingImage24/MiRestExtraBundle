<?php

namespace Mi\Bundle\RestExtraBundle\Tests\EventListener;

use Mi\Bundle\RestExtraBundle\EventListener\ParamConverterListener;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 *
 * @covers Mi\Bundle\RestExtraBundle\EventListener\ParamConverterListener
 */
class ParamConverterListenerTest extends TestCase
{
    /**
     * @test
     */
    public function checkViolation()
    {
        $requestStack = $this->prophesize(RequestStack::class);
        $attributes = $this->prophesize(ParameterBagInterface::class);
        $requestStack->getCurrentRequest()->willReturn((object) ['attributes' => $attributes->reveal()]);

        $listener = new ParamConverterListener($requestStack->reveal());
        $event = $this->prophesize(FilterControllerEvent::class);

        $data = [
            'test' => ['name' => 'dummy'],
        ];

        $attributes->get('_converters')->willReturn($data);
        $attributes->set('_converters', Argument::that(function ($arg) {
            return $arg['test'] instanceof ParamConverter;
        }))->shouldBeCalled();


        call_user_func($listener, $event->reveal());
    }
}
