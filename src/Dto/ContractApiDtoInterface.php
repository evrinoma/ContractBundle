<?php

namespace Evrinoma\ContractBundle\Dto;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\ActiveInterface;
use Evrinoma\DtoCommon\ValueObject\DescriptionInterface;
use Evrinoma\DtoCommon\ValueObject\IdInterface;
use Evrinoma\DtoCommon\ValueObject\NameInterface;

interface ContractApiDtoInterface extends DtoInterface, IdInterface, NameInterface, ActiveInterface, DescriptionInterface
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

    /**
     * @return bool
     */
    public function hasNumber(): bool;

    /**
     * @return string
     */
    public function getNumber(): string;
}
