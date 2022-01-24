<?php

namespace Evrinoma\ContractBundle\Constraint\Property\Common;

use Symfony\Component\Validator\Constraints\NotBlank;

trait IdentityTrait
{
//region SECTION: Getters/Setters
    public function getConstraints(): array
    {
        return [
            new NotBlank(),
        ];
    }

    public function getPropertyName(): string
    {
        return 'identity';
    }
//endregion Getters/Setters
}