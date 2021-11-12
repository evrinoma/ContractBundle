<?php

namespace Evrinoma\ContractBundle\Manager\Side;

use Evrinoma\ContractBundle\Dto\SideApiDtoInterface;
use Evrinoma\ContractBundle\Exception\Side\SideNotFoundException;
use Evrinoma\ContractBundle\Exception\Side\SideProxyException;
use Evrinoma\ContractBundle\Model\Side\SideInterface;

interface QueryManagerInterface
{
//region SECTION: Public
    /**
     * @param SideApiDtoInterface $dto
     *
     * @return array
     * @throws SideNotFoundException
     */
    public function criteria(SideApiDtoInterface $dto): array;
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @param SideApiDtoInterface $dto
     *
     * @return SideInterface
     * @throws SideNotFoundException
     */
    public function get(SideApiDtoInterface $dto): SideInterface;
    /**
     * @param SideApiDtoInterface $dto
     *
     * @return SideInterface
     * @throws SideProxyException
     */
    public function proxy(SideApiDtoInterface $dto): SideInterface;
//endregion Getters/Setters
}