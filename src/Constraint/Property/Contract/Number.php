<?php


namespace Evrinoma\ContractBundle\Constraint\Property\Contract;

use Evrinoma\UtilsBundle\Constraint\Property\ConstraintInterface;
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