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
        if ($dto->hasLeft()) {
            $aliasLeft = AliasInterface::LEFT;
            $builder
                ->leftJoin($alias.'.left', $aliasLeft)
                ->addSelect($aliasLeft);
            if ($dto->getLeft()->hasId()) {
                $builder->andWhere($aliasLeft.'.id = :idLeft')
                    ->setParameter('idLeft', $dto->getLeft()->getId());
            }
        }

        if ($dto->hasRight()) {
            $aliasRight = AliasInterface::RIGHT;
            $builder
                ->leftJoin($alias.'.right', $aliasRight)
                ->addSelect($aliasRight);
            if ($dto->getRight()->hasId()) {
                $builder->andWhere($aliasRight.'.id = :idRight')
                    ->setParameter('idRight', $dto->getRight()->getId());
            }
        }
    }
//endregion Public
}