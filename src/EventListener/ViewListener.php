<?php

namespace Mi\Bundle\RestExtraBundle\EventListener;

use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 */
class ViewListener
{
    public function __construct(private RequestStack $requestStack)
    {
    }

    public function __invoke(ControllerEvent $event)
    {
        $request = $this->requestStack->getCurrentRequest();

        if ($viewParams = $request->attributes->get('_view')) {
            $request->attributes->set('_view', new View($viewParams));
        }
    }
}
