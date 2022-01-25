<?php


namespace Evrinoma\ContractBundle\Constraint\Complex\Side;

use Evrinoma\ContractBundle\Constraint\Complex\Constraint\Side\LeftOrRight;
use Evrinoma\UtilsBundle\Constraint\Complex\ConstraintInterface;

final class Side implements ConstraintInterface
{
    public function getConstraints(): array
    {
        return [new LeftOrRight()];
    }
}