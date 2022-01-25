<?php

namespace Evrinoma\ContractBundle\DependencyInjection\Compiler\Constraint\Complex;


use Evrinoma\ContractBundle\Validator\SideValidator;
use Evrinoma\UtilsBundle\DependencyInjection\Compiler\AbstractConstraint;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class SidePass extends AbstractConstraint implements CompilerPassInterface
{
    public const CONTRACT_SIDE_CONSTRAINT = 'evrinoma.contract.constraint.complex.side';

    protected static string $alias      = self::CONTRACT_SIDE_CONSTRAINT;
    protected static string $class      = SideValidator::class;
    protected static string $methodCall = 'addConstraint';
}