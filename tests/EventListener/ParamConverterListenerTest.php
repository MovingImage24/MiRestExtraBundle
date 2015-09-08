<?php

namespace Mi\Bundle\RestExtraBundle\Tests\EventListener;

use Mi\Bundle\RestExtraBundle\EventListener\ParamConverterListener;
use Prophecy\Argument;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 *
 * @covers Mi\Bundle\RestExtraBundle\EventListener\ParamConverterListener
 */
class ParamConverterListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function checkViolation()
    {
        $listener            = new ParamConverterListener();
        $event               = $this->prophesize(FilterControllerEvent::class);
        $request             = $this->prophesize(Request::class);
        $attributes          = $this->prophesize(ParameterBagInterface::class);
        $request->attributes = $attributes->reveal();

        $data = [
            'test' => ['name' => 'dummy'],
        ];

        $attributes->get('_converters')->willReturn($data);
        $attributes->set('_converters', Argument::that(function ($arg) {
            return $arg['test'] instanceof ParamConverter;
        }))->shouldBeCalled();

        $event->getRequest()->willReturn($request->reveal());


        call_user_func($listener, $event->reveal());
    }
}
