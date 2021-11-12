<?php


namespace Evrinoma\ContractBundle\Entity\Define;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\ContractBundle\Model\Side\AbstractSide;
use Evrinoma\UtilsBundle\Entity\IdentityInterface;
use Evrinoma\UtilsBundle\Entity\IdentityTrait;

/**
 * Class BaseSide
 *
 * @ORM\Table(name="econtract_side")
 * @ORM\Entity()
 */
class BaseSide extends AbstractSide implements IdentityInterface
{
    use IdentityTrait;
}