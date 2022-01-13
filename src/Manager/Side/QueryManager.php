<?php

namespace Evrinoma\ContractBundle\Manager\Side;

use Evrinoma\ContractBundle\Dto\SideApiDtoInterface;
use Evrinoma\ContractBundle\Exception\Side\SideNotFoundException;
use Evrinoma\ContractBundle\Exception\Side\SideProxyException;
use Evrinoma\ContractBundle\Model\Side\SideInterface;
use Evrinoma\ContractBundle\Repository\Side\SideQueryRepositoryInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;
use Evrinoma\UtilsBundle\Rest\RestTrait;

final class QueryManager implements QueryManagerInterface, RestInterface
{
    use RestTrait;

//region SECTION: Fields
    private SideQueryRepositoryInterface $repository;
//endregion Fields

//region SECTION: Constructor
    public function __construct(SideQueryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @param SideApiDtoInterface $dto
     *
     * @return array
     * @throws SideNotFoundException
     */
    public function criteria(SideApiDtoInterface $dto): array
    {
        try {
            $side = $this->repository->findByCriteria($dto);
        } catch (SideNotFoundException $e) {
            throw $e;
        }

        return $side;
    }
//endregion Public

//region SECTION: Getters/Setters
    public function getRestStatus(): int
    {
        return $this->status;
    }

    /**
     * @param SideApiDtoInterface $dto
     *
     * @return SideInterface
     * @throws SideNotFoundException
     */
    public function get(SideApiDtoInterface $dto): SideInterface
    {
        try {
            $side = $this->repository->find($dto->getId());
        } catch (SideNotFoundException $e) {
            throw $e;
        }

        return $side;
    }

    /**
     * @param SideApiDtoInterface $dto
     *
     * @return SideInterface
     * @throws SideProxyException
     */
    public function proxy(SideApiDtoInterface $dto): SideInterface
    {
        try {
            if ($dto->hasId()) {
                $side = $this->repository->proxy($dto->getId());
            } else {
                throw new SideProxyException("Id value is not set while trying get proxy object");
            }
        } catch (SideProxyException $e) {
            throw $e;
        }

        return $side;
    }
//endregion Getters/Setters
}