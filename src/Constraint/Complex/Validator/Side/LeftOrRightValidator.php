<?php


namespace Evrinoma\ContractBundle\Constraint\Complex\Validator\Side;


use Evrinoma\ContractBundle\Constraint\Complex\Constraint\Side\LeftOrRight;
use Evrinoma\ContractBundle\Model\Side\SideInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class LeftOrRightValidator extends ConstraintValidator
{
    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     */
    public function validate($value, Constraint $constraint)
    {
        /** @var $value SideInterface */
        if (($value->hasLeft() && $value->hasRight()) || (!$value->getLeft() && !$value->getRight())) {
            $this->context->buildViolation($constraint->message)
                ->setCode(LeftOrRight::INVALID_LEFT_OR_RIGHT_ERROR)
                ->addViolation();
        }
    }
}