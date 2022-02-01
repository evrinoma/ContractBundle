<?php


namespace Evrinoma\ContractBundle\Model\Side;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\ContractBundle\Model\Contract\ContractInterface;
use Evrinoma\UtilsBundle\Entity\IdTrait;

/**
 * Class AbstractSide
 *
 * @ORM\MappedSuperclass
 */
abstract class AbstractSide implements SideInterface
{
    use IdTrait;

    /**
     * @ORM\ManyToOne(targetEntity="Evrinoma\ContractBundle\Model\Contract\ContractInterface")
     * @ORM\JoinColumn(name="left_id", referencedColumnName="id")
     */
    protected ?ContractInterface $left = null;

    /**
     * @ORM\ManyToOne(targetEntity="Evrinoma\ContractBundle\Model\Contract\ContractInterface")
     * @ORM\JoinColumn(name="right_id", referencedColumnName="id")
     */
    protected ?ContractInterface $right = null;

    /**
     * @return ContractInterface
     */
    public function getRight(): ContractInterface
    {
        return $this->right;
    }

    public function resetLeft(): LeftSideInterface
    {
        $this->left = null;

        return $this;
    }

    public function resetRight(): RightSideInterface
    {
        $this->right = null;

        return $this;
    }

    /**
     * @param ContractInterface $right
     *
     * @return RightSideInterface
     */
    public function setRight(ContractInterface $right): RightSideInterface
    {
        $this->right = $right;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasRight(): bool
    {
        return null !== $this->right;
    }

    /**
     * @return ContractInterface
     */
    public function getLeft(): ContractInterface
    {
        return $this->left;
    }

    /**
     * @param ContractInterface $left
     *
     * @return LeftSideInterface
     */
    public function setLeft(ContractInterface $left): LeftSideInterface
    {
        $this->left = $left;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasLeft(): bool
    {
        return null !== $this->left;
    }
}