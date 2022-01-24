<?php


namespace Evrinoma\ContractBundle\Constraint\Property\Side;

use Evrinoma\ContractBundle\Constraint\Property\Common\SideTrait;
use Evrinoma\UtilsBundle\Constraint\Property\ConstraintInterface;

final class Left implements ConstraintInterface
{
    use SideTrait;

    public function getPropertyName(): string
    {
        return 'left';
    }
}