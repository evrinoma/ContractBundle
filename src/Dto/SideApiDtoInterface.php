<?php

namespace Evrinoma\ContractBundle\Dto;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\IdentityInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\IdInterface;

interface SideApiDtoInterface extends DtoInterface, IdInterface
{
    public const LEFT  = 'left';
    public const RIGHT = 'right';

    /**
     * @return bool
     */
    public function hasRight(): bool;

    /**
     * @return bool
     */
    public function hasLeft(): bool;

    /**
     * @return ContractApiDtoInterface
     */
    public function getRight(): ContractApiDtoInterface;

    /**
     * @return ContractApiDtoInterface
     */
    public function getLeft(): ContractApiDtoInterface;
}
