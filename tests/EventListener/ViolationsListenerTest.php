<?php

namespace Mi\Bundle\RestExtraBundle\Tests\EventListener;

use Mi\Bundle\RestExtraBundle\Controller\ViolationsController;
use Mi\Bundle\RestExtraBundle\EventListener\ViolationsListener;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use stdClass;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @covers ViolationsListener
 */
class ViolationsListenerTest extends TestCase
{
    use ProphecyTrait;

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

        $kernel = $this->getMockBuilder(HttpKernelInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();

        $controller = $this->getMockBuilder(stdClass::class)
            ->addMethods(['__invoke'])
            ->getMock();

        $requestType = HttpKernelInterface::MAIN_REQUEST;
        $event = new  ControllerEvent($kernel, $controller, $request, $requestType);

       // $event->setController()->shouldBeCalled();

        $listener = new ViolationsListener($requestStack->reveal());

        call_user_func($listener, $event);
    }
}
