<?php

namespace Evrinoma\ContractBundle\Repository\Contract;

use Evrinoma\ContractBundle\Model\Contract\ContractInterface;

interface ContractCommandRepositoryInterface
{
    public function save(ContractInterface $type): bool;

    public function remove(ContractInterface $type): bool;
}