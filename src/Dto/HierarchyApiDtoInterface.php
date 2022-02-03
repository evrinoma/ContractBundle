<?php

namespace Evrinoma\ContractBundle\Dto;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\IdentityInterface;
use Evrinoma\DtoCommon\ValueObject\IdInterface;

interface HierarchyApiDtoInterface extends DtoInterface, IdInterface, IdentityInterface
{
    public const HIERARCHY = 'hierarchy';
}
