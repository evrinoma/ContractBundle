<?php

namespace Evrinoma\ContractBundle\Factory;

use Evrinoma\ContractBundle\Dto\ContractApiDtoInterface;
use Evrinoma\ContractBundle\Model\Contract\ContractInterface;

interface ContractFactoryInterface
{
    /**
     * @param ContractApiDtoInterface $dto
     *
     * @return ContractInterface
     */
    public function create(ContractApiDtoInterface $dto): ContractInterface;
}