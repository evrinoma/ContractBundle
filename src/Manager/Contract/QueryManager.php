<?php

namespace Evrinoma\ContractBundle\Manager\Contract;

use Evrinoma\ContractBundle\Dto\ContractApiDtoInterface;
use Evrinoma\ContractBundle\Exception\Contract\ContractNotFoundException;
use Evrinoma\ContractBundle\Exception\Contract\ContractProxyException;
use Evrinoma\ContractBundle\Model\Contract\ContractInterface;
use Evrinoma\ContractBundle\Repository\Contract\ContractQueryRepositoryInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;
use Evrinoma\UtilsBundle\Rest\RestTrait;

final class QueryManager implements QueryManagerInterface, RestInterface
{
    use RestTrait;

//region SECTION: Fields
    private ContractQueryRepositoryInterface $repository;
//endregion Fields

//region SECTION: Constructor
    public function __construct(ContractQueryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @param ContractApiDtoInterface $dto
     *
     * @return array
     * @throws ContractNotFoundException
     */
    public function criteria(ContractApiDtoInterface $dto): array
    {
        try {
            $contract = $this->repository->findByCriteria($dto);
        } catch (ContractNotFoundException $e) {
            throw $e;
        }

        return $contract;
    }
//endregion Public

//region SECTION: Getters/Setters
    public function getRestStatus(): int
    {
        return $this->status;
    }

    /**
     * @param ContractApiDtoInterface $dto
     *
     * @return ContractInterface
     * @throws ContractNotFoundException
     */
    public function get(ContractApiDtoInterface $dto): ContractInterface
    {
        try {
            $contract = $this->repository->find($dto->getId());
        } catch (ContractNotFoundException $e) {
            throw $e;
        }

        return $contract;
    }

    /**
     * @param ContractApiDtoInterface $dto
     *
     * @return ContractInterface
     * @throws ContractProxyException
     */
    public function proxy(ContractApiDtoInterface $dto): ContractInterface
    {
        try {
            if ($dto->hasId()) {
                $contract = $this->repository->proxy($dto->getId());
            } else {
                throw new ContractProxyException("Id value is not set while trying get proxy object");
            }
        } catch (ContractProxyException $e) {
            throw $e;
        }

        return $contract;
    }
//endregion Getters/Setters
}