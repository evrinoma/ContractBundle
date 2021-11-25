<?php

namespace Evrinoma\ContractBundle\Factory;

use Evrinoma\ContractBundle\Dto\ContractApiDtoInterface;
use Evrinoma\ContractBundle\Entity\Contract\BaseContract;
use Evrinoma\ContractBundle\Model\Contract\ContractInterface;

final class ContractFactory implements ContractFactoryInterface
{
    private static string $entityClass = BaseContract::class;

    public function create(ContractApiDtoInterface $dto): ContractInterface
    {
        /** @var BaseContract $type */
        $type = new self::$entityClass;

        $type
            ->setCreatedAt(new \DateTimeImmutable())
            ->setActiveToActive();

        return $type;
    }
}