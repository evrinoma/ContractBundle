<?php

namespace Evrinoma\ContractBundle\Dto;

use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\IdentityTrait;
use Evrinoma\DtoCommon\ValueObject\IdTrait;
use Symfony\Component\HttpFoundation\Request;

class SideApiDto extends AbstractDto implements SideApiDtoInterface
{
    use IdTrait, IdentityTrait;

    public function toDto(Request $request): DtoInterface
    {
       return $this;
    }
}
