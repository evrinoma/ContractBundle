<?php

namespace Evrinoma\ContractBundle\DependencyInjection\Compiler\Constraint\Property;


use Evrinoma\ContractBundle\Validator\TypeValidator;
use Evrinoma\UtilsBundle\DependencyInjection\Compiler\AbstractConstraint;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class TypePass extends AbstractConstraint implements CompilerPassInterface
{
    public const CONTRACT_TYPE_CONSTRAINT = 'evrinoma.contract.constraint.property.type';

    protected static string $alias      = self::CONTRACT_TYPE_CONSTRAINT;
    protected static string $class      = TypeValidator::class;
    protected static string $methodCall = 'addPropertyConstraint';
}