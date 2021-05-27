<?php

namespace Mi\Bundle\RestExtraBundle\EventListener;

use Mi\Bundle\RestExtraBundle\Controller\ViolationsController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ViolationsListener
{
    /** @var RequestStack */
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function __invoke(FilterControllerEvent $event)
    {
        $request = $this->requestStack->getCurrentRequest();

        $violations = $request->attributes->get('violations');
        if ($violations instanceof ConstraintViolationListInterface && $violations->count() > 0) {
            $event->setController(new ViolationsController());
        }
    }
}
