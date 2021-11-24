<?php

namespace Evrinoma\ContractBundle\Mediator\Side;

use Doctrine\ORM\QueryBuilder;
use Evrinoma\ContractBundle\Dto\ContractApiDtoInterface;

interface QueryMediatorInterface
{
    /**
     * @return string
     */
    public function alias(): string;

    /**
     * @param ContractApiDtoInterface $dto
     * @param QueryBuilder              $builder
     *
     * @return mixed
     */
    public function createQuery(ContractApiDtoInterface $dto, QueryBuilder $builder):void;
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @param ContractApiDtoInterface $dto
     * @param QueryBuilder              $builder
     *
     * @return array
     */
    public function getResult(ContractApiDtoInterface $dto, QueryBuilder $builder): array;
}