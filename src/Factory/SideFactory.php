<?php

namespace Evrinoma\ContractBundle\Factory;

use Evrinoma\ContractBundle\Dto\SideApiDtoInterface;
use Evrinoma\ContractBundle\Entity\Side\BaseSide;
use Evrinoma\ContractBundle\Model\Side\SideInterface;

final class SideFactory implements SideFactoryInterface
{
//region SECTION: Fields
    private static string $entityClass = BaseSide::class;

//endregion Fields
    public function __construct(string $entityClass)
    {
        self::$entityClass = $entityClass;
    }

//region SECTION: Public
    public function create(SideApiDtoInterface $dto): SideInterface
    {
        /** @var BaseSide $side */
        return new self::$entityClass;
    }
//endregion Public
}