<?php


namespace Evrinoma\ContractBundle\Model\Contract;

use Evrinoma\ContractBundle\Model\Define\HierarchyInterface;
use Evrinoma\ContractBundle\Model\Define\TypeInterface;
use Evrinoma\UtilsBundle\Entity\ActiveInterface;
use Evrinoma\UtilsBundle\Entity\CreateUpdateAtInterface;
use Evrinoma\UtilsBundle\Entity\DescriptionInterface;
use Evrinoma\UtilsBundle\Entity\IdInterface;

interface ContractInterface extends ActiveInterface, CreateUpdateAtInterface, IdInterface, DescriptionInterface
{
//region SECTION: Getters/Setters
    /**
     * @return TypeInterface
     */
    public function getType(): TypeInterface;

    /**
     * @return HierarchyInterface
     */
    public function getHierarchy(): HierarchyInterface;

    /**
     * @param TypeInterface $type
     *
     * @return ContractInterface
     */
    public function setType(TypeInterface $type): ContractInterface;

    /**
     * @param HierarchyInterface $hierarchy
     *
     * @return ContractInterface
     */
    public function setHierarchy(HierarchyInterface $hierarchy): ContractInterface;

//endregion Getters/Setters
}