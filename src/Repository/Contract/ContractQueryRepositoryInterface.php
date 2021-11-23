<?php

namespace Evrinoma\ContractBundle\Repository\Contract;

use Evrinoma\ContractBundle\Dto\ContractApiDtoInterface;
use Evrinoma\ContractBundle\Exception\Contract\ContractNotFoundException;
use Evrinoma\ContractBundle\Exception\Contract\ContractProxyException;
use Evrinoma\ContractBundle\Model\Contract\ContractInterface;

interface ContractQueryRepositoryInterface
{
//region SECTION: Find Filters Repository
    /**
     * @param ContractApiDtoInterface $dto
     *
     * @return array
     * @throws ContractNotFoundException
     */
    public function findByCriteria(ContractApiDtoInterface $dto): array;

    /**
     * @param string $id
     * @param null   $lockMode
     * @param null   $lockVersion
     *
     * @return ContractInterface
     * @throws ContractNotFoundException
     */
    public function find(string $id, $lockMode = null, $lockVersion = null): ContractInterface;

    /**
     * @param string $id
     *
     * @return ContractInterface
     * @throws ContractProxyException
     */
    public function proxy(string $id): ContractInterface;
//endregion Find Filters Repository
}