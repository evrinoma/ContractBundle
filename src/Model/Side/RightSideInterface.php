<?php


namespace Evrinoma\ContractBundle\Model\Side;

use Evrinoma\ContractBundle\Model\Contract\ContractInterface;

interface RightSideInterface
{
//region SECTION: Getters/Setters
    /**
     * @return RightSideInterface
     */
    public function resetRight(): RightSideInterface;

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
     * @return RightSideInterface
     */
    public function setRight(ContractInterface $right): RightSideInterface;
//endregion Getters/Setters
}