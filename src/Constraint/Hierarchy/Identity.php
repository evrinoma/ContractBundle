<?php


namespace Evrinoma\ContractBundle\Constraint\Hierarchy;

use Evrinoma\ContractBundle\Constraint\Common\IdentityTrait;
use Evrinoma\UtilsBundle\Constraint\ConstraintInterface;

final class Identity implements ConstraintInterface
{
    use IdentityTrait;
}