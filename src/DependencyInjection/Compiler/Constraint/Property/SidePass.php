<?php

namespace Evrinoma\ContractBundle\DependencyInjection\Compiler\Constraint\Property;


use Evrinoma\ContractBundle\Validator\SideValidator;
use Evrinoma\UtilsBundle\DependencyInjection\Compiler\AbstractConstraint;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class SidePass extends AbstractConstraint implements CompilerPassInterface
{
    public const CONTRACT_SIDE_CONSTRAINT = 'evrinoma.contract.constraint.side.property';

    protected static string $alias      = self::CONTRACT_SIDE_CONSTRAINT;
    protected static string $class      = SideValidator::class;
    protected static string $methodCall = 'addPropertyConstraint';
}