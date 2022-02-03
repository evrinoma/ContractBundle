<?php

namespace Evrinoma\ContractBundle\Dto;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\IdentityInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\IdInterface;

interface HierarchyApiDtoInterface extends DtoInterface, IdInterface, IdentityInterface
{
    public const HIERARCHY = 'hierarchy';
}
