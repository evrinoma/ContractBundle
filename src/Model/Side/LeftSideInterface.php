<?php


namespace Evrinoma\ContractBundle\Model\Side;

use Evrinoma\ContractBundle\Model\Contract\ContractInterface;

interface LeftSideInterface
{
//region SECTION: Getters/Setters
    /**
     * @return LeftSideInterface
     */
    public function resetLeft(): LeftSideInterface;

    /**
     * @return bool
     */
    public function hasLeft(): bool;

    /**
     * @return ContractInterface
     */
    public function getLeft(): ContractInterface;

    /**
     * @param ContractInterface $left
     *
     * @return LeftSideInterface
     */
    public function setLeft(ContractInterface $left): LeftSideInterface;
//endregion Getters/Setters
}