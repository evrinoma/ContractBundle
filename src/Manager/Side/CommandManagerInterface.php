<?php

namespace Evrinoma\ContractBundle\Manager\Type;

use Evrinoma\ContractBundle\Dto\TypeApiDtoInterface;
use Evrinoma\ContractBundle\Exception\Type\TypeCannotBeRemovedException;
use Evrinoma\ContractBundle\Exception\Type\TypeInvalidException;
use Evrinoma\ContractBundle\Exception\Type\TypeNotFoundException;
use Evrinoma\ContractBundle\Model\Define\TypeInterface;

interface CommandManagerInterface
{
//region SECTION: Public
    /**
     * @param TypeApiDtoInterface $dto
     *
     * @return TypeInterface
     * @throws TypeInvalidException
     */
    public function post(TypeApiDtoInterface $dto): TypeInterface;

    /**
     * @param TypeApiDtoInterface $dto
     *
     * @return TypeInterface
     * @throws TypeInvalidException
     * @throws TypeNotFoundException
     */
    public function put(TypeApiDtoInterface $dto): TypeInterface;

    /**
     * @param TypeApiDtoInterface $dto
     *
     * @throws TypeCannotBeRemovedException
     * @throws TypeNotFoundException
     */
    public function delete(TypeApiDtoInterface $dto): void;
//endregion Public
}