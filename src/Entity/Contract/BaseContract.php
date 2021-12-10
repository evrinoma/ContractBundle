<?php


namespace Evrinoma\ContractBundle\Entity\Contract;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\ContractBundle\Model\Contract\AbstractContract;
use Evrinoma\ContractBundle\Model\Side\AbstractSide;
use Evrinoma\UtilsBundle\Entity\IdentityInterface;
use Evrinoma\UtilsBundle\Entity\IdentityTrait;

/**
 * Class BaseSide
 *
 * @ORM\Table(name="e_contract_contract")
 * @ORM\Entity()
 */
class BaseContract extends AbstractContract
{
}