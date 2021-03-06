<?php

namespace Evrinoma\ContractBundle\Mediator\Side;

use Evrinoma\ContractBundle\Model\Side\SideInterface;
use Evrinoma\UtilsBundle\Mediator\AbstractCommandMediator;
use Evrinoma\DtoBundle\Dto\DtoInterface;

class CommandMediator extends AbstractCommandMediator implements CommandMediatorInterface
{
//region SECTION: Public
    public function onUpdate(DtoInterface $dto, $entity): SideInterface
    {
        return $entity;
    }

    public function onDelete(DtoInterface $dto, $entity): void
    {
    }

    public function onCreate(DtoInterface $dto, $entity): SideInterface
    {
        return $entity;
    }
//endregion Public
}