<?php

namespace Evrinoma\ContractBundle\Dto\Preserve;

use Evrinoma\ContractBundle\Dto\ContractApiDtoInterface;
use Evrinoma\DtoBundle\Dto\DtoInterface;

interface SideApiDtoInterface
{
//region SECTION: Getters/Setters
    /**
     * @param ContractApiDtoInterface $right
     *
     * @return self
     */
    public function setRight(ContractApiDtoInterface $right): DtoInterface;

    /**
     * @param ContractApiDtoInterface $left
     *
     * @return self
     */
    public function setLeft(ContractApiDtoInterface $left): DtoInterface;
//endregion Getters/Setters
}