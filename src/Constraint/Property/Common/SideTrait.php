<?php

namespace Evrinoma\ContractBundle\Constraint\Property\Common;

use Symfony\Component\Validator\Constraints\NotNull;

trait SideTrait
{
    public function getConstraints(): array
    {
        return [
            new NotNull(),
        ];
    }
}