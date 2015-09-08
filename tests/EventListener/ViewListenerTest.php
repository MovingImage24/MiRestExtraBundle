<?php

namespace Mi\Bundle\RestExtraBundle\Tests\EventListener;

use FOS\RestBundle\Controller\Annotations\View;
use Mi\Bundle\RestExtraBundle\EventListener\ViewListener;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 *
 * @covers Mi\Bundle\RestExtraBundle\EventListener\ViewListener
 */
class ViewListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function setViewParam()
    {
        $event   = $this->prophesize(FilterControllerEvent::class);
        $bag     = $this->prophesize(ParameterBagInterface::class);
        $request = $this->prophesize(Request::class);

        $request->attributes = $bag->reveal();

        $event->getRequest()->willReturn($request->reveal());

        $bag->get('_view')->willReturn(['statusCode' => 401]);

        $bag->set('_view', Argument::type(View::class))->shouldBeCalled();

        $listener = new ViewListener();

        call_user_func($listener, $event->reveal());
    }

    /**
     * @test
     */
    public function dontSetViewParam()
    {
        $event   = $this->prophesize(FilterControllerEvent::class);
        $bag     = $this->prophesize(ParameterBagInterface::class);
        $request = $this->prophesize(Request::class);

        $request->attributes = $bag->reveal();

        $event->getRequest()->willReturn($request->reveal());

        $bag->get('_view')->willReturn(null);

        $listener = new ViewListener();

        call_user_func($listener, $event->reveal());
    }
}
