<?php

namespace Evrinoma\ContractBundle\Repository\Type;

use Evrinoma\ContractBundle\Model\Define\TypeInterface;

interface TypeCommandRepositoryInterface
{
    public function save(TypeInterface $type): bool;

    public function remove(TypeInterface $type): bool;
}