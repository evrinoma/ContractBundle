<?php

namespace Evrinoma\ContractBundle\Dto;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\IdentityInterface;
use Evrinoma\DtoCommon\ValueObject\IdInterface;

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
