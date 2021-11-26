<?php

namespace Evrinoma\ContractBundle\Factory;

use Evrinoma\ContractBundle\Dto\TypeApiDtoInterface;
use Evrinoma\ContractBundle\Entity\Define\BaseType;
use Evrinoma\ContractBundle\Model\Define\TypeInterface;

final class TypeFactory implements TypeFactoryInterface
{
//region SECTION: Fields
    private static string $entityClass = BaseType::class;
//endregion Fields

//region SECTION: Public
    public function create(TypeApiDtoInterface $dto): TypeInterface
    {
        /** @var BaseType $type */
        $type = new self::$entityClass;

        $type->setIdentity(trim($dto->getIdentity()));

        return $type;
    }
//endregion Public
}