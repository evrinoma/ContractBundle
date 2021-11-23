<?php

namespace Evrinoma\ContractBundle\Manager\Contract;

use Evrinoma\ContractBundle\Dto\ContractApiDtoInterface;
use Evrinoma\ContractBundle\Exception\Contract\ContractNotFoundException;
use Evrinoma\ContractBundle\Exception\Contract\ContractProxyException;
use Evrinoma\ContractBundle\Model\Contract\ContractInterface;

interface QueryManagerInterface
{
//region SECTION: Public
    /**
     * @param ContractApiDtoInterface $dto
     *
     * @return array
     * @throws ContractNotFoundException
     */
    public function criteria(ContractApiDtoInterface $dto): array;
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @param ContractApiDtoInterface $dto
     *
     * @return ContractInterface
     * @throws ContractNotFoundException
     */
    public function get(ContractApiDtoInterface $dto): ContractInterface;
    /**
     * @param ContractApiDtoInterface $dto
     *
     * @return ContractInterface
     * @throws ContractProxyException
     */
    public function proxy(ContractApiDtoInterface $dto): ContractInterface;
//endregion Getters/Setters
}