<?php

namespace Evrinoma\ContractBundle\Repository\Side;

use Evrinoma\ContractBundle\Model\Side\SideInterface;

interface SideCommandRepositoryInterface
{
    public function save(SideInterface $type): bool;

    public function remove(SideInterface $type): bool;
}