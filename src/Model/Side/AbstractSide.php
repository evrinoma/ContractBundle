<?php


namespace Evrinoma\ContractBundle\Model\Side;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\UtilsBundle\Entity\IdTrait;

/**
 * Class AbstractSide
 *
 * @ORM\MappedSuperclass
 * @ORM\Table()
 */
abstract class AbstractSide implements SideInterface
{
    use IdTrait;
}