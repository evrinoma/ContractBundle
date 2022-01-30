<?php

namespace Evrinoma\ContractBundle\Factory;

use Evrinoma\ContractBundle\Dto\ContractApiDtoInterface;
use Evrinoma\ContractBundle\Entity\Contract\BaseContract;
use Evrinoma\ContractBundle\Model\Contract\ContractInterface;

final class ContractFactory implements ContractFactoryInterface
{
//region SECTION: Fields
    private static string $entityClass = BaseContract::class;
//endregion Fields

//region SECTION: Public
    public function create(ContractApiDtoInterface $dto): ContractInterface
    {
        /** @var BaseContract $contract */
        $contract = new self::$entityClass;

        $contract
            ->setName(trim($dto->getName()))
            ->setNumber(trim($dto->getNumber()))
            ->setCreatedAt(new \DateTimeImmutable())
            ->setActiveToActive()
            ->setDescription(trim($dto->getDescription()));

        return $contract;
    }
//endregion Public
}