<?php

namespace Evrinoma\ContractBundle\Factory;

use Evrinoma\ContractBundle\Dto\TypeApiDtoInterface;
use Evrinoma\ContractBundle\Model\Define\TypeInterface;

interface TypeFactoryInterface
{
    /**
     * @param TypeApiDtoInterface $dto
     *
     * @return TypeInterface
     */
    public function create(TypeApiDtoInterface $dto): TypeInterface;
}