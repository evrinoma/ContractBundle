<?php

namespace Evrinoma\ContractBundle\Manager\Contract;

use Evrinoma\ContractBundle\Dto\ContractApiDtoInterface;
use Evrinoma\ContractBundle\Exception\Contract\ContractCannotBeRemovedException;
use Evrinoma\ContractBundle\Exception\Contract\ContractInvalidException;
use Evrinoma\ContractBundle\Exception\Contract\ContractNotFoundException;
use Evrinoma\ContractBundle\Model\Contract\ContractInterface;

interface CommandManagerInterface
{
//region SECTION: Public
    /**
     * @param ContractApiDtoInterface $dto
     *
     * @return ContractInterface
     * @throws ContractInvalidException
     */
    public function post(ContractApiDtoInterface $dto): ContractInterface;

    /**
     * @param ContractApiDtoInterface $dto
     *
     * @return ContractInterface
     * @throws ContractInvalidException
     * @throws ContractNotFoundException
     */
    public function put(ContractApiDtoInterface $dto): ContractInterface;

    /**
     * @param ContractApiDtoInterface $dto
     *
     * @throws ContractCannotBeRemovedException
     * @throws ContractNotFoundException
     */
    public function delete(ContractApiDtoInterface $dto): void;
//endregion Public
}