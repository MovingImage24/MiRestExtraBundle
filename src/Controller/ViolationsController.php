<?php

namespace Mi\Bundle\RestExtraBundle\Controller;

use FOS\RestBundle\View\View;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 *
 * @codeCoverageIgnore
 */
class ViolationsController
{
    /**
     * @param $violations ConstraintViolationListInterface
     *
     * @return View
     */
    public function __invoke(ConstraintViolationListInterface $violations)
    {
        return new View($violations, 400);
    }
}
