<?php


namespace Evrinoma\ContractBundle\Dto\Preserve;


use Evrinoma\ContractBundle\Dto\HierarchyApiDtoInterface as BaseHierarchyApiDtoInterface;
use Evrinoma\ContractBundle\Dto\TypeApiDtoInterface as BaseTypeApiDtoInterface;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\ActiveInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\DescriptionInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\NameInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\NumberInterface;

interface ContractApiDtoInterface extends IdInterface, NameInterface, ActiveInterface, DescriptionInterface, NumberInterface
{
    /**
     * @param BaseHierarchyApiDtoInterface $hierarchyApiDto
     *
     * @return DtoInterface
     */
    public function setHierarchyApiDto(BaseHierarchyApiDtoInterface $hierarchyApiDto): DtoInterface;

    /**
     * @param BaseTypeApiDtoInterface $typeApiDto
     *
     * @return DtoInterface
     */
    public function setTypeApiDto(BaseTypeApiDtoInterface $typeApiDto): DtoInterface;
}