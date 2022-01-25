<?php


namespace Evrinoma\ContractBundle\Constraint\Complex\Constraint\Side;

use Evrinoma\ContractBundle\Constraint\Complex\Validator\Side\LeftOrRightValidator;
use Evrinoma\UtilsBundle\Constraint\Complex\AbstractConstraint;

/**
 * @Annotation
 */
class LeftOrRight extends AbstractConstraint
{
    public const INVALID_LEFT_OR_RIGHT_ERROR = 'b2b438ae-9f7f-42b0-aa8b-84622fbb4c5c';

    public string $message = 'Should be set left or right';

    public function validatedBy()
    {
        return LeftOrRightValidator::class;
    }
}
