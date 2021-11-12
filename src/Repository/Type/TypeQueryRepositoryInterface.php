<?php

namespace Evrinoma\ContractBundle\Repository\Type;

use Evrinoma\ContractBundle\Dto\TypeApiDtoInterface;
use Evrinoma\ContractBundle\Exception\Type\TypeNotFoundException;
use Evrinoma\ContractBundle\Exception\Type\TypeProxyException;
use Evrinoma\ContractBundle\Model\Define\TypeInterface;

interface TypeQueryRepositoryInterface
{
//region SECTION: Find Filters Repository
    /**
     * @param TypeApiDtoInterface $dto
     *
     * @return array
     * @throws TypeNotFoundException
     */
    public function findByCriteria(TypeApiDtoInterface $dto): array;

    /**
     * @param string $id
     * @param null   $lockMode
     * @param null   $lockVersion
     *
     * @return TypeInterface
     * @throws TypeNotFoundException
     */
    public function find(string $id, $lockMode = null, $lockVersion = null): TypeInterface;

    /**
     * @param string $id
     *
     * @return TypeInterface
     * @throws TypeProxyException
     */
    public function proxy(string $id): TypeInterface;
//endregion Find Filters Repository
}