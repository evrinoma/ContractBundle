<?php


namespace Evrinoma\ContractBundle\Constraint\Property\Side;

use Evrinoma\ContractBundle\Constraint\Property\Common\SideTrait;
use Evrinoma\UtilsBundle\Constraint\Property\ConstraintInterface;

final class Right implements ConstraintInterface
{
    use SideTrait;

    public function getPropertyName(): string
    {
        return 'right';
    }
}