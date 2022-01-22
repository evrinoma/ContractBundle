<?php

namespace Evrinoma\ContractBundle\Constraint\Common;

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