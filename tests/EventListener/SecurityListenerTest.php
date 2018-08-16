<?php

namespace Mi\Bundle\RestExtraBundle\Tests\EventListener;

use Mi\Bundle\RestExtraBundle\EventListener\SecurityListener;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 *
 * @covers Mi\Bundle\RestExtraBundle\EventListener\SecurityListener
 */
class SecurityListenerTest extends TestCase
{
    /**
     * @test
     */
    public function setViewParam()
    {
        $requestStack = $this->prophesize(RequestStack::class);
        $attributes = $this->prophesize(ParameterBagInterface::class);
        $attributes->get('_security')->willReturn(['expression' => 'security_expression']);
        $attributes->set('_security', Argument::type(Security::class))->shouldBeCalled();
        $requestStack->getCurrentRequest()->willReturn((object) ['attributes' => $attributes->reveal()]);

        $event = $this->prophesize(FilterControllerEvent::class);

        $listener = new SecurityListener($requestStack->reveal());

        call_user_func($listener, $event->reveal());
    }

    /**
     * @test
     */
    public function dontSetViewParam()
    {
        $requestStack = $this->prophesize(RequestStack::class);
        $attributes = $this->prophesize(ParameterBagInterface::class);
        $attributes->get('_security')->willReturn(null);
        $requestStack->getCurrentRequest()->willReturn((object) ['attributes' => $attributes->reveal()]);

        $event = $this->prophesize(FilterControllerEvent::class);

        $listener = new SecurityListener($requestStack->reveal());

        call_user_func($listener, $event->reveal());
    }
}
