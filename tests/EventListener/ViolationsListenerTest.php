<?php

namespace Mi\Bundle\RestExtraBundle\Tests\EventListener;

use Mi\Bundle\RestExtraBundle\Controller\ViolationsController;
use Mi\Bundle\RestExtraBundle\EventListener\ViolationsListener;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 *
 * @covers ViolationsListener
 */
class ViolationsListenerTest extends TestCase
{
    /**
     * @test
     */
    public function checkViolation()
    {
        $violations = $this->prophesize(ConstraintViolationListInterface::class);
        $violations->count()->willReturn(1);

        $requestStack = $this->prophesize(RequestStack::class);
        $attributes = $this->prophesize(ParameterBagInterface::class);
        $attributes->get('violations')->willReturn($violations->reveal());
        $requestStack->getCurrentRequest()->willReturn((object) ['attributes' => $attributes->reveal()]);

        $event = $this->prophesize(ControllerEvent::class);

        $event->setController(Argument::type(ViolationsController::class))->shouldBeCalled();

        $listener = new ViolationsListener($requestStack->reveal());

        call_user_func($listener, $event->reveal());
    }
}
