<?php


namespace Evrinoma\ContractBundle\Constraint\Property\Contract;

use Evrinoma\UtilsBundle\Constraint\Property\ConstraintInterface;
use Symfony\Component\Validator\Constraints\NotNull;

final class Description implements ConstraintInterface
{
    public function getConstraints(): array
    {
        return [
            new NotNull(),
        ];
    }

    public function getPropertyName(): string
    {
        return 'description';
    }
}