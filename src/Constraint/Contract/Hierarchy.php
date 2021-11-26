<?php


namespace Evrinoma\ContractBundle\Constraint\Contract;

use Evrinoma\ContractBundle\Constraint\Common\HierarchyTrait;
use Evrinoma\UtilsBundle\Constraint\ConstraintInterface;

final class Hierarchy implements ConstraintInterface
{
    use HierarchyTrait;
}