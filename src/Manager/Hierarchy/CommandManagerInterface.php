<?php

namespace Evrinoma\ContractBundle\Manager\Hierarchy;

use Evrinoma\ContractBundle\Dto\HierarchyApiDtoInterface;
use Evrinoma\ContractBundle\Exception\Hierarchy\HierarchyCannotBeRemovedException;
use Evrinoma\ContractBundle\Exception\Hierarchy\HierarchyInvalidException;
use Evrinoma\ContractBundle\Exception\Hierarchy\HierarchyNotFoundException;
use Evrinoma\ContractBundle\Model\Define\HierarchyInterface;

interface CommandManagerInterface
{
//region SECTION: Public
    /**
     * @param HierarchyApiDtoInterface $dto
     *
     * @return HierarchyInterface
     * @throws HierarchyInvalidException
     */
    public function post(HierarchyApiDtoInterface $dto): HierarchyInterface;

    /**
     * @param HierarchyApiDtoInterface $dto
     *
     * @return HierarchyInterface
     * @throws HierarchyInvalidException
     * @throws HierarchyNotFoundException
     */
    public function put(HierarchyApiDtoInterface $dto): HierarchyInterface;

    /**
     * @param HierarchyApiDtoInterface $dto
     *
     * @throws HierarchyCannotBeRemovedException
     * @throws HierarchyNotFoundException
     */
    public function delete(HierarchyApiDtoInterface $dto): void;
//endregion Public
}