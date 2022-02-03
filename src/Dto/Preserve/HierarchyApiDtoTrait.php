<?php

namespace Evrinoma\ContractBundle\Dto\Preserve;

use Evrinoma\DtoBundle\Dto\DtoInterface;

trait HierarchyApiDtoTrait
{
    /**
     * @param string $identity
     *
     * @return DtoInterface
     */
    public function setIdentity(string $identity): DtoInterface
    {
        return parent::setIdentity($identity);
    }

    /**
     * @param int|null $id
     *
     * @return DtoInterface
     */
    public function setId(?int $id): DtoInterface
    {
        return parent::setId($id);
    }
}
