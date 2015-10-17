<?php

namespace Mi\Bundle\RestExtraBundle\Tests\EventListener;

use Mi\Bundle\RestExtraBundle\EventListener\SecurityListener;
use Prophecy\Argument;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 *
 * @covers Mi\Bundle\RestExtraBundle\EventListener\SecurityListener
 */
class SecurityListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function setViewParam()
    {
        $event = $this->prophesize(FilterControllerEvent::class);
        $bag = $this->prophesize(ParameterBagInterface::class);
        $request = $this->prophesize(Request::class);

        $request->attributes = $bag->reveal();

        $event->getRequest()->willReturn($request->reveal());

        $bag->get('_security')->willReturn(['expression' => 'security_expression']);

        $bag->set('_security', Argument::type(Security::class))->shouldBeCalled();

        $listener = new SecurityListener();

        call_user_func($listener, $event->reveal());
    }

    /**
     * @test
     */
    public function dontSetViewParam()
    {
        $event = $this->prophesize(FilterControllerEvent::class);
        $bag = $this->prophesize(ParameterBagInterface::class);
        $request = $this->prophesize(Request::class);

        $request->attributes = $bag->reveal();

        $event->getRequest()->willReturn($request->reveal());

        $bag->get('_security')->willReturn(null);

        $listener = new SecurityListener();

        call_user_func($listener, $event->reveal());
    }
}
