<?php

namespace Mi\Bundle\RestExtraBundle\EventListener;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 */
class SecurityListener
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

        if ($securityParams = $request->attributes->get('_security')) {
            $request->attributes->set('_security', new Security($securityParams));
        }
    }
}
