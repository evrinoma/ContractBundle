<?php

namespace Evrinoma\ContractBundle\Mediator\Contract;

use Doctrine\ORM\QueryBuilder;
use Evrinoma\ContractBundle\Dto\ContractApiDtoInterface;
use Evrinoma\ContractBundle\Repository\AliasInterface;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\UtilsBundle\Mediator\AbstractQueryMediator;

class QueryMediator extends AbstractQueryMediator implements QueryMediatorInterface
{
//region SECTION: Fields
    protected static string $alias = AliasInterface::CONTRACT;
//endregion Fields

//region SECTION: Public
    public function createQuery(DtoInterface $dto, QueryBuilder $builder): void
    {
        $alias = $this->alias();

        /** @var $dto ContractApiDtoInterface */
        if ($dto->hasTypeApiDto()) {
            $aliasType = AliasInterface::TYPE;
            $builder
                ->leftJoin($alias.'.type', $aliasType)
                ->addSelect($aliasType);

            if ($dto->getTypeApiDto()->hasId()) {
                $builder->andWhere($aliasType.'.id = :idType')
                    ->setParameter('idType', $dto->getTypeApiDto()->getId());
            }
            if ($dto->getTypeApiDto()->hasIdentity()) {
                $builder->andWhere($aliasType.'.identity like :identityType')
                    ->setParameter('identityType', '%'.$dto->getTypeApiDto()->getIdentity().'%');
            }
        }

        if ($dto->hasHierarchyApiDto()) {
            $aliasHierarchy = AliasInterface::HIERARCHY;
            $builder
                ->leftJoin($alias.'.hierarchy', $aliasHierarchy)
                ->addSelect($aliasHierarchy);

            if ($dto->getHierarchyApiDto()->hasId()) {
                $builder->andWhere($aliasHierarchy.'.id = :idHierarchy')
                    ->setParameter('idHierarchy', $dto->getHierarchyApiDto()->getId());
            }
            if ($dto->getHierarchyApiDto()->hasIdentity()) {
                $builder->andWhere($aliasHierarchy.'.identity like :identityHierarchy')
                    ->setParameter('identityHierarchy', '%'.$dto->getHierarchyApiDto()->getIdentity().'%');
            }
        }

        if ($dto->hasDescription()) {
            $builder
                ->andWhere($alias.'.description like :description')
                ->setParameter('description', '%'.$dto->getDescription().'%');
        }

        if ($dto->hasName()) {
            $builder
                ->andWhere($alias.'.name like :name')
                ->setParameter('name', '%'.$dto->getName().'%');
        }

        if ($dto->hasActive()) {
            $builder
                ->andWhere($alias.'.active = :active')
                ->setParameter('active', $dto->getActive());
        }
    }
//endregion Public
}