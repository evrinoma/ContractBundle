<?php

namespace Evrinoma\ContractBundle\Factory;

use Evrinoma\ContractBundle\Dto\HierarchyApiDtoInterface;
use Evrinoma\ContractBundle\Model\Define\HierarchyInterface;

interface HierarchyFactoryInterface
{
//region SECTION: Public
    /**
     * @param HierarchyApiDtoInterface $dto
     *
     * @return HierarchyInterface
     */
    public function create(HierarchyApiDtoInterface $dto): HierarchyInterface;
//endregion Public
}