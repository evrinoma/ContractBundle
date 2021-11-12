<?php

namespace Evrinoma\ContractBundle\Factory;

use Evrinoma\ContractBundle\Dto\SideApiDtoInterface;
use Evrinoma\ContractBundle\Entity\Side\BaseSide;
use Evrinoma\ContractBundle\Model\Side\SideInterface;

final class SideFactory implements SideFactoryInterface
{
    private static string $entityClass = BaseSide::class;

    public function create(SideApiDtoInterface $dto): SideInterface
    {
        /** @var BaseSide $type */
        $type = new self::$entityClass;

        $type
            ->setIdentity($dto->getIdentity());

        return $type;
    }
}