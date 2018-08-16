<?php

namespace Mi\Bundle\RestExtraBundle\EventListener;

use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 */
class ViewListener
{
    /** @var RequestStack */
    private $requestStack;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @param FilterControllerEvent $event
     */
    public function __invoke(FilterControllerEvent $event)
    {
        $request = $this->requestStack->getCurrentRequest();

        if ($viewParams = $request->attributes->get('_view')) {
            $request->attributes->set('_view', new View($viewParams));
        }
    }
}
