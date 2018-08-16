<?php

namespace Mi\Bundle\RestExtraBundle\Tests\EventListener;

use Mi\Bundle\RestExtraBundle\Controller\ViolationsController;
use Mi\Bundle\RestExtraBundle\EventListener\ViolationsListener;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 *
 * @covers Mi\Bundle\RestExtraBundle\EventListener\ViolationsListener
 */
class ViolationsListenerTest extends TestCase
{
    /**
     * @test
     */
    public function checkViolation()
    {
        $event = $this->prophesize(FilterControllerEvent::class);
        $bag = $this->prophesize(ParameterBagInterface::class);
        $violations = $this->prophesize(ConstraintViolationListInterface::class);

        $event->getRequest()->willReturn((object) ['attributes' => $bag->reveal()]);
        $event->setController(Argument::type(ViolationsController::class))->shouldBeCalled();

        $bag->get('violations')->willReturn($violations->reveal());

        $violations->count()->willReturn(1);

        $listener = new ViolationsListener('violations');

        call_user_func($listener, $event->reveal());
    }
}
