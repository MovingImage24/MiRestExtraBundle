<?php

namespace Mi\Bundle\RestExtraBundle\Tests\EventListener;

use Mi\Bundle\RestExtraBundle\EventListener\ParamConverterListener;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use stdClass;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;


/**
 * @covers ParamConverterListener
 */
class ParamConverterListenerTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function checkViolation()
    {
        $requestStack = $this->prophesize(RequestStack::class);
        $attributes = $this->prophesize(ParameterBagInterface::class);
        $requestStack->getCurrentRequest()->willReturn((object)['attributes' => $attributes->reveal()]);

        $listener = new ParamConverterListener($requestStack->reveal());
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

        $data = [
            'test' => ['name' => 'dummy'],
        ];

        $attributes->get('_converters')->willReturn($data);
        $attributes->set('_converters', Argument::that(function ($arg) {
            return $arg['test'] instanceof ParamConverter;
        }))->shouldBeCalled();


        call_user_func($listener, $event);
    }
}
