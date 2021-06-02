<?php

namespace Mi\Bundle\RestExtraBundle\EventListener;

use Mi\Bundle\RestExtraBundle\Controller\ViolationsController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 */
class ViolationsListener
{
    public function __construct(private $violationErrorArgument, private RequestStack $requestStack)
    {
    }

    public function __invoke(ControllerEvent $event)
    {
        $request = $this->requestStack->getCurrentRequest();

        $violations = $request->attributes->get($this->violationErrorArgument);
        if ($violations instanceof ConstraintViolationListInterface && $violations->count() > 0) {
            $event->setController(new ViolationsController());
        }
    }
}
