<?php

namespace Evrinoma\ContractBundle\Mediator\Side;


use Evrinoma\ContractBundle\Dto\SideApiDtoInterface;
use Evrinoma\ContractBundle\Exception\Side\SideCannotBeCreatedException;
use Evrinoma\ContractBundle\Exception\Side\SideCannotBeRemovedException;
use Evrinoma\ContractBundle\Exception\Side\SideCannotBeSavedException;
use Evrinoma\ContractBundle\Model\Side\SideInterface;

interface CommandMediatorInterface
{
    /**
     * @param SideApiDtoInterface $dto
     * @param SideInterface       $entity
     *
     * @return SideInterface
     * @throws SideCannotBeSavedException
     */
    public function onUpdate(SideApiDtoInterface $dto, SideInterface $entity): SideInterface;

    /**
     * @param SideApiDtoInterface $dto
     * @param SideInterface       $entity
     *
     * @throws SideCannotBeRemovedException
     */
    public function onDelete(SideApiDtoInterface $dto, SideInterface $entity): void;

    /**
     * @param SideApiDtoInterface $dto
     * @param SideInterface       $entity
     *
     * @return SideInterface
     * @throws SideCannotBeSavedException
     * @throws SideCannotBeCreatedException
     */
    public function onCreate(SideApiDtoInterface $dto, SideInterface $entity): SideInterface;
}