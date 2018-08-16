<?php

namespace Mi\Bundle\RestExtraBundle\EventListener;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 */
class ParamConverterListener
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
     * Modifies the ParamConverterManager instance.
     *
     * @param FilterControllerEvent $event
     */
    public function __invoke(FilterControllerEvent $event)
    {
        $request = $this->requestStack->getCurrentRequest();

        /** @var array $converters */
        if ($converters = $request->attributes->get('_converters')) {
            foreach ($converters as &$configuration) {
                $configuration = new ParamConverter($configuration);
            }
            unset($configuration);

            $request->attributes->set('_converters', $converters);
        }
    }
}
