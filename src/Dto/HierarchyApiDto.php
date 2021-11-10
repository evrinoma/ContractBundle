<?php

namespace Evrinoma\ContractBundle\Dto;

use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\IdentityTrait;
use Evrinoma\DtoCommon\ValueObject\IdTrait;
use Evrinoma\HeaderBundle\Dto\HeaderApiDtoInterface;
use Symfony\Component\HttpFoundation\Request;

class HierarchyApiDto extends  AbstractDto implements HeaderApiDtoInterface
{
    use IdTrait, IdentityTrait;

    public function toDto(Request $request): DtoInterface
    {
        return $this;
    }
}
