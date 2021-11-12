<?php


namespace Evrinoma\ContractBundle\Model\Side;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\ContractBundle\Model\Contract\ContractInterface;
use Evrinoma\UtilsBundle\Entity\IdTrait;

abstract class AbstractSide implements SideInterface
{
    use IdTrait;

    /**
     * @ORM\ManyToOne(targetEntity="Evrinoma\ContractBundle\Model\Contract\ContractInterface", inversedBy="leftSide")
     */
    protected ContractInterface $left;

    /**
     * @ORM\ManyToOne(targetEntity="Evrinoma\ContractBundle\Model\Contract\ContractInterface", inversedBy="rightSide")
     */
    protected ContractInterface $right;

    /**
     * @return ContractInterface
     */
    public function getRight(): ContractInterface
    {
        return $this->right;
    }

    /**
     * @param ContractInterface $right
     *
     * @return SideInterface
     */
    public function setRight(ContractInterface $right): SideInterface
    {
        $this->right = $right;

        return $this;
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
     * @return SideInterface
     */
    public function setLeft(ContractInterface $left): SideInterface
    {
        $this->left = $left;

        return $this;
    }
}