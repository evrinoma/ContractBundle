<?php

namespace Evrinoma\ContractBundle\Mediator\Side;

use Doctrine\ORM\QueryBuilder;
use Evrinoma\ContractBundle\Dto\SideApiDtoInterface;


interface QueryMediatorInterface
{
    /**
     * @return string
     */
    public function alias(): string;

    /**
     * @param SideApiDtoInterface $dto
     * @param QueryBuilder              $builder
     *
     * @return mixed
     */
    public function createQuery(SideApiDtoInterface $dto, QueryBuilder $builder):void;
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @param SideApiDtoInterface $dto
     * @param QueryBuilder              $builder
     *
     * @return array
     */
    public function getResult(SideApiDtoInterface $dto, QueryBuilder $builder): array;
}