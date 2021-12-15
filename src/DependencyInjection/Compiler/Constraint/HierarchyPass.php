<?php

namespace Evrinoma\ContractBundle\DependencyInjection\Compiler\Constraint;


use Evrinoma\ContractBundle\Validator\HierarchyValidator;
use Evrinoma\UtilsBundle\DependencyInjection\Compiler\AbstractConstraint;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class HierarchyPass extends AbstractConstraint implements CompilerPassInterface
{
    public const CONTRACT_HIERARCHY_CONSTRAINT = 'evrinoma.contract.constraint.hierarchy';

    protected static string $alias = self::CONTRACT_HIERARCHY_CONSTRAINT;
    protected static string $class = HierarchyValidator::class;
    protected static string $methodCall = 'addConstraint';
}