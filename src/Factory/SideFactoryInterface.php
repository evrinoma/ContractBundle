<?php

namespace Evrinoma\ContractBundle\Factory;

use Evrinoma\ContractBundle\Dto\SideApiDtoInterface;
use Evrinoma\ContractBundle\Model\Side\SideInterface;

interface SideFactoryInterface
{
//region SECTION: Public
    /**
     * @param SideApiDtoInterface $dto
     *
     * @return SideInterface
     */
    public function create(SideApiDtoInterface $dto): SideInterface;
//endregion Public
}