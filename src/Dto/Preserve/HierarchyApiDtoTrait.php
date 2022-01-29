<?php

namespace Evrinoma\ContractBundle\Dto\Preserve;

trait HierarchyApiDtoTrait
{
    /**
     * @param string $identity
     */
    public function setIdentity(string $identity): void
    {
        parent::setIdentity($identity);
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        parent::setId($id);
    }
}
