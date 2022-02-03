<?php

namespace Evrinoma\ContractBundle\Dto\Preserve;

use Evrinoma\ContractBundle\Dto\ContractApiDtoInterface;

interface SideApiDtoInterface
{
//region SECTION: Getters/Setters
    /**
     * @param ContractApiDtoInterface $right
     *
     * @return self
     */
    public function setRight(ContractApiDtoInterface $right): self;

    /**
     * @param ContractApiDtoInterface $left
     *
     * @return self
     */
    public function setLeft(ContractApiDtoInterface $left): self;
//endregion Getters/Setters
}