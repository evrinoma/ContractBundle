<?php


namespace Evrinoma\ContractBundle\Model\Side;

use Evrinoma\ContractBundle\Model\Contract\ContractInterface;

interface LeftSideInterface
{
//region SECTION: Getters/Setters
    /**
     * @return ContractInterface
     */
    public function getLeft(): ContractInterface;

    /**
     * @param ContractInterface $left
     *
     * @return SideInterface
     */
    public function setLeft(ContractInterface $left): SideInterface;
//endregion Getters/Setters
}