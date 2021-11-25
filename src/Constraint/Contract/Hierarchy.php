<?php


namespace Evrinoma\ContractBundle\Constraint\Bunch;

use Evrinoma\ContractBundle\Constraint\Common\HierarchyTrait;
use Evrinoma\UtilsBundle\Constraint\ConstraintInterface;

final class Hierarchy implements ConstraintInterface
{
    use HierarchyTrait;
}