<?php

namespace Evrinoma\ContractBundle\Dto\Preserve;

trait TypeApiDtoTrait
{
    /**
     * @param string $identity
     *
     * @return self
     */
    public function setIdentity(string $identity): self
    {
        return parent::setIdentity($identity);
    }

    /**
     * @param int|null $id
     *
     * @return self
     */
    public function setId(?int $id): self
    {
        return parent::setId($id);
    }
}
