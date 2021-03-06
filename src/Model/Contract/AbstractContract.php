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
use Evrinoma\UtilsBundle\Entity\DescriptionTrait;
use Evrinoma\UtilsBundle\Entity\IdTrait;
use Evrinoma\UtilsBundle\Entity\NameTrait;

/**
 * Class AbstractType
 *
 * @ORM\MappedSuperclass
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="idx_contract", columns={"type_id", "hierarchy_id", "name", "description", "number"})})
 */
abstract class AbstractContract implements ContractInterface
{
    use IdTrait, ActiveTrait, CreateUpdateAtTrait, NameTrait, DescriptionTrait;

    /**
     * @var ArrayCollection|LeftSideInterface[]
     *
     * @ORM\ManyToMany(targetEntity="Evrinoma\ContractBundle\Model\Side\LeftSideInterface")
     * @ORM\JoinTable(
     *      joinColumns={@ORM\JoinColumn(name="left_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id", referencedColumnName="id")}
     * )
     */
    protected $leftSide;
    /**
     * @var ArrayCollection|RightSideInterface[]
     *
     * @ORM\ManyToMany(targetEntity="Evrinoma\ContractBundle\Model\Side\RightSideInterface")
     * @ORM\JoinTable(
     *      joinColumns={@ORM\JoinColumn(name="right_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id", referencedColumnName="id")}
     * )
     */
    protected $rightSide;
    /**
     * @var TypeInterface
     *
     * @ORM\ManyToOne(targetEntity="Evrinoma\ContractBundle\Model\Define\TypeInterface")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id", nullable=false)
     */
    protected TypeInterface $type;
    /**
     * @var HierarchyInterface
     *
     * @ORM\ManyToOne(targetEntity="Evrinoma\ContractBundle\Model\Define\HierarchyInterface")
     * @ORM\JoinColumn(name="hierarchy_id", referencedColumnName="id", nullable=false)
     */
    protected HierarchyInterface $hierarchy;
    /**
     * @var string
     *
     * @ORM\Column(name="number", type="string", length=255, nullable=false)
     */
    protected string $number;
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
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @param string $number
     *
     * @return ContractInterface
     */
    public function setNumber(string $number): ContractInterface
    {
        $this->number = $number;

        return $this;
    }

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