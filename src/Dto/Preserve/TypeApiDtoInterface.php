<?php

namespace Evrinoma\ContractBundle\Dto\Preserve;

use Evrinoma\DtoCommon\ValueObject\Immutable\IdentityInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\IdInterface;

interface TypeApiDtoInterface extends IdInterface, IdentityInterface
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
