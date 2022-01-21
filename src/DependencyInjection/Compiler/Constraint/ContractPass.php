<?php

namespace Evrinoma\ContractBundle\DependencyInjection\Compiler\Constraint;


use Evrinoma\ContractBundle\Validator\ContractValidator;
use Evrinoma\UtilsBundle\DependencyInjection\Compiler\AbstractConstraint;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class ContractPass extends AbstractConstraint implements CompilerPassInterface
{
    public const CONTRACT_CODE_CONSTRAINT = 'evrinoma.contract.constraint.contract';

    protected static string $alias = self::CONTRACT_CODE_CONSTRAINT;
    protected static string $class = ContractValidator::class;
    protected static string $methodCall = 'addConstraint';
}