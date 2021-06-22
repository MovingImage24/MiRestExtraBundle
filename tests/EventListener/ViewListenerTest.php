<?php

namespace Mi\Bundle\RestExtraBundle\Tests\EventListener;

use FOS\RestBundle\Controller\Annotations\View;
use Mi\Bundle\RestExtraBundle\EventListener\ViewListener;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use stdClass;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * @covers ViewListener
 */
class ViewListenerTest extends TestCase
{
    use ProphecyTrait;
    /**
     * @test
     */
    public function setViewParam()
    {
        $requestStack = $this->prophesize(RequestStack::class);
        $attributes = $this->prophesize(ParameterBagInterface::class);
        $attributes->get('_template')->willReturn(['statusCode' => 401]);
        $attributes->set('_template', Argument::type(View::class))->shouldBeCalled();
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

        $listener = new ViewListener($requestStack->reveal());

        call_user_func($listener, $event);
    }

    /**
     * @test
     */
    public function dontSetViewParam()
    {
        $requestStack = $this->prophesize(RequestStack::class);
        $attributes = $this->prophesize(ParameterBagInterface::class);
        $attributes->get('_template')->willReturn(null);
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

        $listener = new ViewListener($requestStack->reveal());

        call_user_func($listener, $event);
    }
}
