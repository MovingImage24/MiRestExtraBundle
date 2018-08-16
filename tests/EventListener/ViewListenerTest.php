<?php

namespace Mi\Bundle\RestExtraBundle\Tests\EventListener;

use FOS\RestBundle\Controller\Annotations\View;
use Mi\Bundle\RestExtraBundle\EventListener\ViewListener;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 *
 * @covers Mi\Bundle\RestExtraBundle\EventListener\ViewListener
 */
class ViewListenerTest extends TestCase
{
    /**
     * @test
     */
    public function setViewParam()
    {
        $requestStack = $this->prophesize(RequestStack::class);
        $attributes = $this->prophesize(ParameterBagInterface::class);
        $attributes->get('_view')->willReturn(['statusCode' => 401]);
        $attributes->set('_view', Argument::type(View::class))->shouldBeCalled();
        $requestStack->getCurrentRequest()->willReturn((object) ['attributes' => $attributes->reveal()]);

        $event = $this->prophesize(FilterControllerEvent::class);

        $listener = new ViewListener($requestStack->reveal());

        call_user_func($listener, $event->reveal());
    }

    /**
     * @test
     */
    public function dontSetViewParam()
    {
        $requestStack = $this->prophesize(RequestStack::class);
        $attributes = $this->prophesize(ParameterBagInterface::class);
        $attributes->get('_view')->willReturn(null);
        $requestStack->getCurrentRequest()->willReturn((object) ['attributes' => $attributes->reveal()]);

        $event = $this->prophesize(FilterControllerEvent::class);

        $listener = new ViewListener($requestStack->reveal());

        call_user_func($listener, $event->reveal());
    }
}
