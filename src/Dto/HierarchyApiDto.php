<?php

namespace Evrinoma\ContractBundle\Dto;

use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdentityTrait;
use Evrinoma\DtoCommon\ValueObject\Immutable\IdTrait;
use Symfony\Component\HttpFoundation\Request;

class HierarchyApiDto extends AbstractDto implements HierarchyApiDtoInterface
{
    use IdTrait, IdentityTrait;

    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {
            $id       = $request->get(HierarchyApiDtoInterface::ID);
            $identity = $request->get(HierarchyApiDtoInterface::IDENTITY);

            if ($identity) {
                $this->setIdentity($identity);
            }

            if ($id) {
                $this->setId($id);
            }
        }

        return $this;
    }
}
