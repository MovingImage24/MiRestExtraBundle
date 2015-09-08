<?php

namespace Mi\Bundle\RestExtraBundle\EventListener;

use Mi\Bundle\RestExtraBundle\Controller\ViolationsController;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 */
class ViolationsListener
{
    private  $violationErrorArgument;

    /**
     * @param string $violationErrorArgument
     */
    public function __construct($violationErrorArgument)
    {
        $this->violationErrorArgument = $violationErrorArgument;
    }

    /**
     * @param FilterControllerEvent $event
     */
    public function __invoke(FilterControllerEvent $event)
    {
        $request = $event->getRequest();

        $violations = $request->attributes->get($this->violationErrorArgument);
        if ($violations instanceof ConstraintViolationListInterface && $violations->count() > 0) {
            $event->setController(new ViolationsController());
        }
    }
}
