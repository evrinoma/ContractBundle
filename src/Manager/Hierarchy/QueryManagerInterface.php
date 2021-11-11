<?php

namespace Evrinoma\ContractBundle\Manager\Hierarchy;

use Evrinoma\ContractBundle\Dto\HierarchyApiDtoInterface;
use Evrinoma\ContractBundle\Exception\Hierarchy\HierarchyNotFoundException;
use Evrinoma\ContractBundle\Exception\Hierarchy\HierarchyProxyException;
use Evrinoma\ContractBundle\Model\Define\HierarchyInterface;

interface QueryManagerInterface
{
//region SECTION: Public
    /**
     * @param HierarchyApiDtoInterface $dto
     *
     * @return array
     * @throws HierarchyNotFoundException
     */
    public function criteria(HierarchyApiDtoInterface $dto): array;
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @param HierarchyApiDtoInterface $dto
     *
     * @return HierarchyInterface
     * @throws HierarchyNotFoundException
     */
    public function get(HierarchyApiDtoInterface $dto): HierarchyInterface;
    /**
     * @param HierarchyApiDtoInterface $dto
     *
     * @return HierarchyInterface
     * @throws HierarchyProxyException
     */
    public function proxy(HierarchyApiDtoInterface $dto): HierarchyInterface;
//endregion Getters/Setters
}