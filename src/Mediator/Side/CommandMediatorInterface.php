<?php

namespace Evrinoma\ContractBundle\Mediator\Side;

use Evrinoma\ContractBundle\Dto\ContractApiDtoInterface;
use Evrinoma\ContractBundle\Exception\Contract\ContractCannotBeCreatedException;
use Evrinoma\ContractBundle\Exception\Contract\ContractCannotBeRemovedException;
use Evrinoma\ContractBundle\Exception\Contract\ContractCannotBeSavedException;
use Evrinoma\ContractBundle\Model\Contract\ContractInterface;

interface CommandMediatorInterface
{
    /**
     * @param ContractApiDtoInterface $dto
     * @param ContractInterface       $entity
     *
     * @return ContractInterface
     * @throws ContractCannotBeSavedException
     */
    public function onUpdate(ContractApiDtoInterface $dto, ContractInterface $entity): ContractInterface;

    /**
     * @param ContractApiDtoInterface $dto
     * @param ContractInterface       $entity
     *
     * @throws ContractCannotBeRemovedException
     */
    public function onDelete(ContractApiDtoInterface $dto, ContractInterface $entity): void;

    /**
     * @param ContractApiDtoInterface $dto
     * @param ContractInterface       $entity
     *
     * @return ContractInterface
     * @throws ContractCannotBeSavedException
     * @throws ContractCannotBeCreatedException
     */
    public function onCreate(ContractApiDtoInterface $dto, ContractInterface $entity): ContractInterface;
}