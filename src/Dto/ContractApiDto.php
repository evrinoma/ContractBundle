<?php

namespace Evrinoma\ContractBundle\Dto;

use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\ActiveTrait;
use Evrinoma\DtoCommon\ValueObject\IdentityTrait;
use Evrinoma\DtoCommon\ValueObject\IdTrait;
use Evrinoma\DtoCommon\ValueObject\NameTrait;
use Symfony\Component\HttpFoundation\Request;

class ContractApiDto extends AbstractDto implements ContractApiDtoInterface
{
    use IdTrait, IdentityTrait, ActiveTrait, NameTrait;

//region SECTION: Dto
    public function toDto(Request $request): DtoInterface
    {
        return $this;
    }
//endregion SECTION: Dto
}
