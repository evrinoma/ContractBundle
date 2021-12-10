<?php


namespace Evrinoma\ContractBundle\Entity\Side;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\ContractBundle\Model\Side\AbstractSide;
use Evrinoma\UtilsBundle\Entity\IdentityInterface;
use Evrinoma\UtilsBundle\Entity\IdentityTrait;

/**
 * Class BaseSide
 *
 * @ORM\Table(name="e_contract_side")
 * @ORM\Entity()
 */
class BaseSide extends AbstractSide implements IdentityInterface
{
    use IdentityTrait;
}