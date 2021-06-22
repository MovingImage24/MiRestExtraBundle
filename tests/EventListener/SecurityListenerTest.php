<?php

namespace Mi\Bundle\RestExtraBundle\Tests\EventListener;

use Mi\Bundle\RestExtraBundle\EventListener\SecurityListener;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use stdClass;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * @covers SecurityListener
 */
class SecurityListenerTest extends TestCase
{
    use ProphecyTrait;
    /**
     * @test
     */
    public function setViewParam()
    {
        $requestStack = $this->prophesize(RequestStack::class);
        $attributes = $this->prophesize(ParameterBagInterface::class);
        $attributes->get('_security')->willReturn(['expression' => 'security_expression']);
        $attributes->set('_security', Argument::type(Security::class))->shouldBeCalled();
        $requestStack->getCurrentRequest()->willReturn((object)['attributes' => $attributes->reveal()]);

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
        $listener = new SecurityListener($requestStack->reveal());

        call_user_func($listener, $event);
    }

    /**
     * @test
     */
    public function dontSetViewParam()
    {
        $requestStack = $this->prophesize(RequestStack::class);
        $attributes = $this->prophesize(ParameterBagInterface::class);
        $attributes->get('_security')->willReturn(null);
        $attributes->set()->shouldNotBeCalled();
        $requestStack->getCurrentRequest()->willReturn((object)['attributes' => $attributes->reveal()]);

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

        $listener = new SecurityListener($requestStack->reveal());

        call_user_func($listener, $event);

        static::assertNull($requestStack->reveal()->getCurrentRequest()->attributes->get('_security'));
    }
}
