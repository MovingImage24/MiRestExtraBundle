<?php

namespace Mi\Bundle\RestExtraBundle\Tests\EventListener;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Request\ParamFetcher;
use Mi\Bundle\RestExtraBundle\EventListener\ParamFetcherListener;
use Mi\Bundle\RestExtraBundle\Tests\EventListener\Fixtures\Controller;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 *
 * @covers Mi\Bundle\RestExtraBundle\EventListener\ParamFetcherListener
 */
class ParamFetcherListenerTest extends TestCase
{
    /**
     * @var ParamFetcherListener
     */
    private $listener;
    private $paramFetcher;
    private $requestStack;
    private $event;
    private $attributes;

    /**
     * @test
     */
    public function shouldSetParamsWithOtherClass()
    {
        $controller = new Controller();
        $param = new RequestParam();
        $param->name = 'test';
        $param->strict = false;

        $this->attributes->get('_params')->willReturn(['test' => ['strict' => false, 'class' => RequestParam::class]]);

        $this->paramFetcher->setController([$controller, '__invoke'])->shouldBeCalled();
        $this->paramFetcher->addParam($param)->shouldBeCalled();

        $this->attributes->get('_params')->willReturn(['test' => ['strict' => false, 'class' => RequestParam::class]]);

        $this->requestStack->getCurrentRequest()->willReturn((object) ['attributes' => $this->attributes->reveal()]);
        $this->event->getController()->willReturn($controller);

        call_user_func($this->listener, $this->event->reveal());
    }

    /**
     * @test
     */
    public function shouldSetParams()
    {
        $controller = new Controller();
        $param = new QueryParam();
        $param->name = 'test';
        $param->strict = false;

        $this->attributes->get('_params')->willReturn(['test' => ['strict' => false]]);

        $this->paramFetcher->setController([$controller, '__invoke'])->shouldBeCalled();
        $this->paramFetcher->addParam($param)->shouldBeCalled();

        $this->requestStack->getCurrentRequest()->willReturn((object) ['attributes' => $this->attributes->reveal()]);
        $this->event->getController()->willReturn($controller);

        call_user_func($this->listener, $this->event->reveal());
    }

    protected function setUp(): void
    {
        $this->requestStack = $this->prophesize(RequestStack::class);
        $this->paramFetcher = $this->prophesize(ParamFetcher::class);
        $this->event = $this->prophesize(FilterControllerEvent::class);
        $this->attributes = $this->prophesize(ParameterBagInterface::class);

        $this->listener = new ParamFetcherListener($this->paramFetcher->reveal(), $this->requestStack->reveal());
    }
}
