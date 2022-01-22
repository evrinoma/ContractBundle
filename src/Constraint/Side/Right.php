<?php


namespace Evrinoma\ContractBundle\Constraint\Side;

use Evrinoma\ContractBundle\Constraint\Common\SideTrait;
use Evrinoma\UtilsBundle\Constraint\ConstraintInterface;

final class Right implements ConstraintInterface
{
    use SideTrait;

    public function getPropertyName(): string
    {
        return 'right';
    }
}