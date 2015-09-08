<?php

namespace Mi\Bundle\RestExtraBundle\Tests\EventListener;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
use Mi\Bundle\RestExtraBundle\EventListener\ParamFetcherListener;
use Mi\Bundle\RestExtraBundle\Tests\EventListener\Fixtures\Controller;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 * 
 * @covers Mi\Bundle\RestExtraBundle\EventListener\ParamFetcherListener
 */
class ParamFetcherListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ParamFetcherListener
     */
    private $listener;
    private $paramFetcher;

    /**
     * @test
     */
    public function shouldSetParams()
    {
        $event = $this->prophesize(FilterControllerEvent::class);
        $attributes = $this->prophesize(ParameterBagInterface::class);
        $controller = new Controller();
        $param = new QueryParam();
        $param->name = 'test';
        $param->strict = false;

        $attributes->get('_params')->willReturn(['test' => ['strict' => false]]);

        $this->paramFetcher->setController([$controller, '__invoke'])->shouldBeCalled();
        $this->paramFetcher->addParam($param)->shouldBeCalled();

        $event->getRequest()->willReturn((object)['attributes' => $attributes->reveal()]);
        $event->getController()->willReturn($controller);

        call_user_func($this->listener, $event->reveal());
    }

    protected function setUp()
    {
        $this->paramFetcher = $this->prophesize(ParamFetcher::class);
        $this->listener = new ParamFetcherListener($this->paramFetcher->reveal());
    }
}
