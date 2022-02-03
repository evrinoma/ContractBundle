<?php

namespace Evrinoma\ContractBundle\Dto;

use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\IdentityTrait;
use Evrinoma\DtoCommon\ValueObject\IdTrait;
use Symfony\Component\HttpFoundation\Request;

class HierarchyApiDto extends  AbstractDto implements HierarchyApiDtoInterface
{
    use IdTrait, IdentityTrait;

    /**
     * @param string $identity
     */
    protected function setIdentity(string $identity): void
    {
        $this->identity = $identity;
    }

    /**
     * @param int|null $id
     */
    protected function setId(?int $id): void
    {
        $this->id = $id;
    }

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
