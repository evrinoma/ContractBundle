<?php


namespace Evrinoma\ContractBundle\Constraint\Property\Type;

use Evrinoma\ContractBundle\Constraint\Property\Common\IdentityTrait;
use Evrinoma\UtilsBundle\Constraint\Property\ConstraintInterface;

final class Identity implements ConstraintInterface
{
    use IdentityTrait;
}