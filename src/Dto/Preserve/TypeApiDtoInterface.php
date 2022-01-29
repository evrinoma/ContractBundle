<?php

namespace Evrinoma\ContractBundle\Dto\Preserve;

interface TypeApiDtoInterface
{
    /**
     * @param string $identity
     */
    public function setIdentity(string $identity): void;

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void;
}
