<?php

namespace Mi\Bundle\RestExtraBundle\EventListener;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 */
class ParamFetcherListener
{
    private $paramFetcher;

    /**
     * @param ParamFetcher $paramFetcher
     */
    public function __construct(ParamFetcher $paramFetcher)
    {
        $this->paramFetcher = $paramFetcher;
    }

    /**
     * @param FilterControllerEvent $event
     */
    public function __invoke(FilterControllerEvent $event)
    {
        $request = $event->getRequest();
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
