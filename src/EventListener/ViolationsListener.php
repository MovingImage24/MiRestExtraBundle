<?php

namespace Mi\Bundle\RestExtraBundle\EventListener;

use Mi\Bundle\RestExtraBundle\Controller\ViolationsController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 */
class ViolationsListener
{
    private $violationErrorArgument;

    /** @var RequestStack */
    private $requestStack;

    /**
     * @param string       $violationErrorArgument
     * @param RequestStack $requestStack
     */
    public function __construct($violationErrorArgument, RequestStack $requestStack)
    {
        $this->violationErrorArgument = $violationErrorArgument;
        $this->requestStack = $requestStack;
    }

    /**
     * @param FilterControllerEvent $event
     */
    public function __invoke(FilterControllerEvent $event)
    {
        $request = $this->requestStack->getCurrentRequest();

        $violations = $request->attributes->get($this->violationErrorArgument);
        if ($violations instanceof ConstraintViolationListInterface && $violations->count() > 0) {
            $event->setController(new ViolationsController());
        }
    }
}
