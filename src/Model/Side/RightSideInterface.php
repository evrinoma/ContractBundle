<?php


namespace Evrinoma\ContractBundle\Model\Side;

use Evrinoma\ContractBundle\Model\Contract\ContractInterface;

interface RightSideInterface
{
//region SECTION: Getters/Setters
    /**
     * @return bool
     */
    public function hasRight(): bool;

    /**
     * @return ContractInterface
     */
    public function getRight(): ContractInterface;

    /**
     * @param ContractInterface $right
     *
     * @return SideInterface
     */
    public function setRight(ContractInterface $right): SideInterface;
//endregion Getters/Setters
}