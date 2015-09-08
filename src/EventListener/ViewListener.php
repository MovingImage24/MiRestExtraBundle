<?php

namespace Mi\Bundle\RestExtraBundle\EventListener;

use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 */
class ViewListener
{
    /**
     * @param FilterControllerEvent $event
     */
    public function __invoke(FilterControllerEvent $event)
    {
        $request = $event->getRequest();

        if ($viewParams = $request->attributes->get('_view')) {
            $request->attributes->set('_view', new View($viewParams));
        }
    }
}
