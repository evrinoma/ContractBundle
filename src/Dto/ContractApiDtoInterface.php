<?php

namespace Evrinoma\ContractBundle\Dto;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\ActiveInterface;
use Evrinoma\DtoCommon\ValueObject\IdInterface;
use Evrinoma\DtoCommon\ValueObject\NameInterface;

interface ContractApiDtoInterface extends DtoInterface, IdInterface, NameInterface, ActiveInterface
{

}
