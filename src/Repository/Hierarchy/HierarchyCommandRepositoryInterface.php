<?php

namespace Evrinoma\ContractBundle\Repository\Hierarchy;

use Evrinoma\ContractBundle\Model\Define\HierarchyInterface;

interface HierarchyCommandRepositoryInterface
{
    public function save(HierarchyInterface $type): bool;

    public function remove(HierarchyInterface $type): bool;
}