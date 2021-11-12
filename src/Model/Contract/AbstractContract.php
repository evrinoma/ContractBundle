<?php


namespace Evrinoma\ContractBundle\Model\Contract;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Evrinoma\ContractBundle\Model\Define\HierarchyInterface;
use Evrinoma\ContractBundle\Model\Define\TypeInterface;
use Evrinoma\ContractBundle\Model\Side\LeftSideInterface;
use Evrinoma\ContractBundle\Model\Side\RightSideInterface;
use Evrinoma\UtilsBundle\Entity\ActiveTrait;
use Evrinoma\UtilsBundle\Entity\CreateUpdateAtTrait;
use Evrinoma\UtilsBundle\Entity\IdTrait;

/**
 * Class AbstractType
 *
 * @ORM\MappedSuperclass
 * @ORM\Table()
 */
abstract class AbstractContract implements ContractInterface
{
    use IdTrait, ActiveTrait, CreateUpdateAtTrait;

//region SECTION: Fields
    /**
     * @var ArrayCollection|LeftSideInterface[]
     *
     * @ORM\OneToMany(targetEntity="Evrinoma\ContractBundle\Model\Side\LeftSideInterface", mappedBy="left")
     */
    protected ArrayCollection $leftSide;
    /**
     * @var ArrayCollection|RightSideInterface[]
     *
     * @ORM\OneToMany(targetEntity="Evrinoma\ContractBundle\Model\Side\RightSideInterface", mappedBy="right")
     */
    protected ArrayCollection $rightSide;
    /**
     * @var TypeInterface
     *
     * @ORM\ManyToOne(targetEntity="Evrinoma\ContractBundle\Model\Define\TypeInterface")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    private TypeInterface $type;
    /**
     * @var HierarchyInterface
     *
     * @ORM\ManyToOne(targetEntity="Evrinoma\ContractBundle\Model\Define\HierarchyInterface")
     * @ORM\JoinColumn(name="hierarchy_id", referencedColumnName="id")
     */
    private HierarchyInterface $hierarchy;
//endregion Fields

//region SECTION: Constructor
    public function __construct()
    {
        $this->leftSide  = new ArrayCollection();
        $this->rightSide = new ArrayCollection();
    }
//endregion Constructor

//region SECTION: Getters/Setters
    /**
     * @return ArrayCollection|LeftSideInterface[]
     */
    public function getLeftSide(): Collection
    {
        return $this->leftSide;
    }

    /**
     * @return ArrayCollection|RightSideInterface[]
     */
    public function getRightSide(): Collection
    {
        return $this->rightSide;
    }

    /**
     * @return TypeInterface
     */
    public function getType(): TypeInterface
    {
        return $this->type;
    }

    /**
     * @return HierarchyInterface
     */
    public function getHierarchy(): HierarchyInterface
    {
        return $this->hierarchy;
    }

    /**
     * @param ArrayCollection|RightSideInterface[] $rightSide
     */
    public function setRightSide($rightSide): void
    {
        $this->rightSide = $rightSide;
    }

    /**
     * @param TypeInterface $type
     *
     * @return ContractInterface
     */
    public function setType(TypeInterface $type): ContractInterface
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param HierarchyInterface $hierarchy
     *
     * @return ContractInterface
     */
    public function setHierarchy(HierarchyInterface $hierarchy): ContractInterface
    {
        $this->hierarchy = $hierarchy;

        return $this;
    }


//endregion Getters/Setters
}