<?php


namespace Evrinoma\ContractBundle\Model\Define;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\UtilsBundle\Entity\IdentityTrait;
use Evrinoma\UtilsBundle\Entity\IdTrait;

/**
 * Class AbstractType
 *
 * @ORM\MappedSuperclass
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="idx_identity", columns={"identity"})})
 */
abstract class AbstractType implements TypeInterface
{
    use IdTrait, IdentityTrait;
}