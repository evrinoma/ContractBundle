<?php

namespace Evrinoma\ContractBundle\Manager\Side;

use Evrinoma\ContractBundle\Dto\SideApiDtoInterface;
use Evrinoma\ContractBundle\Exception\Side\SideCannotBeRemovedException;
use Evrinoma\ContractBundle\Exception\Side\SideInvalidException;
use Evrinoma\ContractBundle\Exception\Side\SideNotFoundException;
use Evrinoma\ContractBundle\Model\Side\SideInterface;

interface CommandManagerInterface
{
//region SECTION: Public
    /**
     * @param SideApiDtoInterface $dto
     *
     * @return SideInterface
     * @throws SideInvalidException
     */
    public function post(SideApiDtoInterface $dto): SideInterface;

    /**
     * @param SideApiDtoInterface $dto
     *
     * @return SideInterface
     * @throws SideInvalidException
     * @throws SideNotFoundException
     */
    public function put(SideApiDtoInterface $dto): SideInterface;

    /**
     * @param SideApiDtoInterface $dto
     *
     * @throws SideCannotBeRemovedException
     * @throws SideNotFoundException
     */
    public function delete(SideApiDtoInterface $dto): void;
//endregion Public
}