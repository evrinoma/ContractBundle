<?php

namespace Evrinoma\ContractBundle\Repository\Side;

use Evrinoma\ContractBundle\Dto\SideApiDtoInterface;
use Evrinoma\ContractBundle\Exception\Side\SideNotFoundException;
use Evrinoma\ContractBundle\Exception\Side\SideProxyException;
use Evrinoma\ContractBundle\Model\Side\SideInterface;

interface SideQueryRepositoryInterface
{
//region SECTION: Find Filters Repository
    /**
     * @param SideApiDtoInterface $dto
     *
     * @return array
     * @throws SideNotFoundException
     */
    public function findByCriteria(SideApiDtoInterface $dto): array;

    /**
     * @param string $id
     * @param null   $lockMode
     * @param null   $lockVersion
     *
     * @return SideInterface
     * @throws SideNotFoundException
     */
    public function find(string $id, $lockMode = null, $lockVersion = null): SideInterface;

    /**
     * @param string $id
     *
     * @return SideInterface
     * @throws SideProxyException
     */
    public function proxy(string $id): SideInterface;
//endregion Find Filters Repository
}