<?php

namespace Evrinoma\ContractBundle\DependencyInjection\Compiler\Constraint\Complex;


use Evrinoma\ContractBundle\Validator\ContractValidator;
use Evrinoma\UtilsBundle\DependencyInjection\Compiler\AbstractConstraint;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class ContractPass extends AbstractConstraint implements CompilerPassInterface
{
//region SECTION: Fields
    public const CONTRACT_SIDE_CONSTRAINT = 'evrinoma.contract.constraint.complex.contract';

    protected static string $alias      = self::CONTRACT_SIDE_CONSTRAINT;
    protected static string $class      = ContractValidator::class;
    protected static string $methodCall = 'addConstraint';
//endregion Fields
}