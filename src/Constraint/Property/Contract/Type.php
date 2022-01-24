<?php


namespace Evrinoma\ContractBundle\Constraint\Property\Contract;

use Evrinoma\ContractBundle\Constraint\Property\Common\TypeTrait;
use Evrinoma\UtilsBundle\Constraint\Property\ConstraintInterface;

final class Type implements ConstraintInterface
{
    use TypeTrait;
}