<?php

namespace Mi\Bundle\RestExtraBundle\EventListener;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 */
class SecurityListener
{
    public function __construct(private RequestStack $requestStack)
    {
    }

    public function __invoke(ControllerEvent $event)
    {
        $request = $this->requestStack->getCurrentRequest();

        if ($securityParams = $request->attributes->get('_security')) {
            $request->attributes->set('_security', new Security($securityParams));
        }
    }
}
