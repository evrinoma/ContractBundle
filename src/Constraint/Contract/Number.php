<?php


namespace Evrinoma\ContractBundle\Constraint\Contract;

use Evrinoma\UtilsBundle\Constraint\ConstraintInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class Number implements ConstraintInterface
{
    public function getConstraints(): array
    {
        return [
            new NotBlank(),
        ];
    }

    public function getPropertyName(): string
    {
        return 'number';
    }
}