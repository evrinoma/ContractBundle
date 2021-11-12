<?php

namespace Evrinoma\ContractBundle\Factory;

use Evrinoma\ContractBundle\Dto\TypeApiDtoInterface;
use Evrinoma\ContractBundle\Entity\Define\BaseType;
use Evrinoma\ContractBundle\Model\Define\TypeInterface;

final class TypeFactory implements TypeFactoryInterface
{
    private static string $entityClass = BaseType::class;

    public function create(TypeApiDtoInterface $dto): TypeInterface
    {
        /** @var BaseType $type */
        $type = new self::$entityClass;

        $type
            ->setIdentity($dto->getIdentity());

        return $type;
    }
}