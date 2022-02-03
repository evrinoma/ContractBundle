<?php


namespace Evrinoma\ContractBundle\Dto\Preserve;


use Evrinoma\DtoCommon\ValueObject\Mutable\ActiveInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\DescriptionInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\NameInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\NumberInterface;

interface ContractApiDtoInterface extends IdInterface, NameInterface, ActiveInterface, DescriptionInterface, NumberInterface
{

}