<?php


namespace Evrinoma\ContractBundle\Constraint\Property\Contract;

use Evrinoma\ContractBundle\Constraint\Property\Common\HierarchyTrait;
use Evrinoma\UtilsBundle\Constraint\Property\ConstraintInterface;

final class Hierarchy implements ConstraintInterface
{
    use HierarchyTrait;
}