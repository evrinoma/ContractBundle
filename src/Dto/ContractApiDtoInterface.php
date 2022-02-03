<?php

namespace Evrinoma\ContractBundle\Dto;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\ActiveInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\DescriptionInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\IdInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\NameInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\NumberInterface;

interface ContractApiDtoInterface extends DtoInterface, IdInterface, NameInterface, ActiveInterface, DescriptionInterface, NumberInterface
{
    /**
     * @return bool
     */
    public function hasTypeApiDto(): bool;

    /**
     * @return bool
     */
    public function hasHierarchyApiDto(): bool;

    /**
     * @return HierarchyApiDtoInterface
     */
    public function getHierarchyApiDto(): HierarchyApiDtoInterface;

    /**
     * @return TypeApiDtoInterface
     */
    public function getTypeApiDto(): TypeApiDtoInterface;
}
