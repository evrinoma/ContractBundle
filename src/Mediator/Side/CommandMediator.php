<?php

namespace Evrinoma\ContractBundle\Mediator\Side;

use Evrinoma\UtilsBundle\Mediator\AbstractCommandMediator;
use Evrinoma\ContractBundle\Model\Contract\ContractInterface;
use Evrinoma\DtoBundle\Dto\DtoInterface;

class CommandMediator extends AbstractCommandMediator implements CommandMediatorInterface
{
//region SECTION: Public
    public function onUpdate(DtoInterface $dto, $entity): ContractInterface
    {
        return $entity;
    }

    public function onDelete(DtoInterface $dto, $entity): void
    {
    }

    public function onCreate(DtoInterface $dto, $entity): ContractInterface
    {
        return $entity;
    }
//endregion Public
}