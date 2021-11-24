<?php

namespace Evrinoma\ContractBundle\Mediator\Side;

use Doctrine\ORM\QueryBuilder;
use Evrinoma\ContractBundle\Dto\SideApiDtoInterface;
use Evrinoma\ContractBundle\Repository\AliasInterface;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\UtilsBundle\Mediator\AbstractQueryMediator;

class QueryMediator extends AbstractQueryMediator implements QueryMediatorInterface
{
//region SECTION: Fields
    protected static string $alias = AliasInterface::SIDE;
//endregion Fields

//region SECTION: Public
    public function createQuery(DtoInterface $dto, QueryBuilder $builder): void
    {
        $alias = $this->alias();

        /** @var $dto SideApiDtoInterface */
        if ($dto->hasTypeApiDto() && $dto->getTypeApiDto()->hasBrief()) {
            $aliasType = AliasInterface::TYPE;
        }

        if ($dto->hasHierarchyApiDto() && $dto->getHierarchyApiDto()->hasId()) {
            $aliasHierarchy = AliasInterface::HIERARCHY;
        }
    }
//endregion Public
}