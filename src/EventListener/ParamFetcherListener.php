<?php

namespace Mi\Bundle\RestExtraBundle\EventListener;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 */
class ParamFetcherListener
{
    private ParamFetcher $paramFetcher;
    private RequestStack $requestStack;

    public function __construct(ParamFetcher $paramFetcher, RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $this->paramFetcher = $paramFetcher;
    }

    /**
     * @param ControllerEvent $event
     */
    public function __invoke(ControllerEvent $event)
    {
        $request = $this->requestStack->getCurrentRequest();
        $controller = $event->getController();

        if (is_callable($controller) && method_exists($controller, '__invoke')) {
            $controller = [$controller, '__invoke'];
        }

        $this->paramFetcher->setController($controller);

        /** @var array $queryParams */
        if ($queryParams = $request->attributes->get('_params')) {
            foreach ($queryParams as $name => $queryParamConfig) {

                $class = QueryParam::class;

                if (array_key_exists('class', $queryParamConfig)) {
                    $class = $queryParamConfig['class'];
                    unset($queryParamConfig['class']);
                }

                $queryParam = new $class;
                $queryParam->name = $name;
                foreach ($queryParamConfig as $key => $value) {
                    $queryParam->{$key} = $value;
                }

                $this->paramFetcher->addParam($queryParam);
            }
        }
    }
}
