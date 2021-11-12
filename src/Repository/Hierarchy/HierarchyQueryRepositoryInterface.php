<?php

namespace Evrinoma\ContractBundle\Repository\Hierarchy;

use Evrinoma\ContractBundle\Dto\HierarchyApiDtoInterface;
use Evrinoma\ContractBundle\Exception\Hierarchy\HierarchyNotFoundException;
use Evrinoma\ContractBundle\Exception\Hierarchy\HierarchyProxyException;
use Evrinoma\ContractBundle\Model\Define\HierarchyInterface;

interface HierarchyQueryRepositoryInterface
{
//region SECTION: Find Filters Repository
    /**
     * @param HierarchyApiDtoInterface $dto
     *
     * @return array
     * @throws HierarchyNotFoundException
     */
    public function findByCriteria(HierarchyApiDtoInterface $dto): array;

    /**
     * @param string $id
     * @param null   $lockMode
     * @param null   $lockVersion
     *
     * @return HierarchyInterface
     * @throws HierarchyNotFoundException
     */
    public function find(string $id, $lockMode = null, $lockVersion = null): HierarchyInterface;

    /**
     * @param string $id
     *
     * @return HierarchyInterface
     * @throws HierarchyProxyException
     */
    public function proxy(string $id): HierarchyInterface;
//endregion Find Filters Repository
}