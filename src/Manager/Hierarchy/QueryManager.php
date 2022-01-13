<?php

namespace Evrinoma\ContractBundle\Manager\Hierarchy;

use Evrinoma\ContractBundle\Dto\HierarchyApiDtoInterface;
use Evrinoma\ContractBundle\Exception\Hierarchy\HierarchyNotFoundException;
use Evrinoma\ContractBundle\Exception\Hierarchy\HierarchyProxyException;
use Evrinoma\ContractBundle\Model\Define\HierarchyInterface;
use Evrinoma\ContractBundle\Repository\Hierarchy\HierarchyQueryRepositoryInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;
use Evrinoma\UtilsBundle\Rest\RestTrait;

final class QueryManager implements QueryManagerInterface, RestInterface
{
    use RestTrait;

//region SECTION: Fields
    private HierarchyQueryRepositoryInterface $repository;
//endregion Fields

//region SECTION: Constructor
    public function __construct(HierarchyQueryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @param HierarchyApiDtoInterface $dto
     *
     * @return array
     * @throws HierarchyNotFoundException
     */
    public function criteria(HierarchyApiDtoInterface $dto): array
    {
        try {
            $hierarchy = $this->repository->findByCriteria($dto);
        } catch (HierarchyNotFoundException $e) {
            throw $e;
        }

        return $hierarchy;
    }
//endregion Public

//region SECTION: Getters/Setters
    public function getRestStatus(): int
    {
        return $this->status;
    }

    /**
     * @param HierarchyApiDtoInterface $dto
     *
     * @return HierarchyInterface
     * @throws HierarchyNotFoundException
     */
    public function get(HierarchyApiDtoInterface $dto): HierarchyInterface
    {
        try {
            $hierarchy = $this->repository->find($dto->getId());
        } catch (HierarchyNotFoundException $e) {
            throw $e;
        }

        return $hierarchy;
    }

    /**
     * @param HierarchyApiDtoInterface $dto
     *
     * @return HierarchyInterface
     * @throws HierarchyProxyException
     */
    public function proxy(HierarchyApiDtoInterface $dto): HierarchyInterface
    {
        try {
            if ($dto->hasId()) {
                $hierarchy = $this->repository->proxy($dto->getId());
            } else {
                throw new HierarchyProxyException("Id value is not set while trying get proxy object");
            }
        } catch (HierarchyProxyException $e) {
            throw $e;
        }

        return $hierarchy;
    }
//endregion Getters/Setters
}