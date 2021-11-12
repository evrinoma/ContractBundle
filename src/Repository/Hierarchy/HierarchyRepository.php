<?php

namespace Evrinoma\ContractBundle\Repository\Hierarchy;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMInvalidArgumentException;
use Evrinoma\ContractBundle\Dto\HierarchyApiDtoInterface;
use Evrinoma\ContractBundle\Exception\Hierarchy\HierarchyCannotBeRemovedException;
use Evrinoma\ContractBundle\Exception\Hierarchy\HierarchyCannotBeSavedException;
use Evrinoma\ContractBundle\Exception\Hierarchy\HierarchyNotFoundException;
use Evrinoma\ContractBundle\Exception\Hierarchy\HierarchyProxyException;
use Evrinoma\ContractBundle\Model\Define\HierarchyInterface;

class HierarchyRepository extends ServiceEntityRepository implements HierarchyRepositoryInterface
{

//region SECTION: Public
    public function save(HierarchyInterface $hierarchy): bool
    {
        try {
            $this->getEntityManager()->persist($hierarchy);
        } catch (ORMInvalidArgumentException $e) {
            throw new HierarchyCannotBeSavedException($e->getMessage());
        }

        return true;
    }

    public function remove(HierarchyInterface $hierarchy): bool
    {
        try {
            $this->getEntityManager()->remove($hierarchy);
        } catch (ORMInvalidArgumentException $e) {
            throw new HierarchyCannotBeRemovedException($e->getMessage());
        }

        return true;
    }

    public function proxy(string $id): HierarchyInterface
    {
        $em = $this->getEntityManager();

        $hierarchy = $em->getReference($this->getEntityName(), $id);

        if (!$em->contains($hierarchy)) {
            throw new HierarchyProxyException("Proxy doesn't exist with $id");
        }

        return $hierarchy;
    }
//endregion Public

//region SECTION: Find Filters Repository
    public function findByCriteria(HierarchyApiDtoInterface $dto): array
    {
        $builder = $this->createQueryBuilder('hierarchy');

        if ($dto->hasIdentity()) {
            $builder
                ->andWhere('hierarchy.identity like :identity')
                ->setParameter('identity', '%'.$dto->getIdentity().'%');
        }

        $hierarchy = $builder->getQuery()->getResult();

        if (count($hierarchy) === 0) {
            throw new HierarchyNotFoundException("Cannot find type by findByCriteria");
        }

        return $hierarchy;
    }

    public function find($id, $lockMode = null, $lockVersion = null): HierarchyInterface
    {
        /** @var HierarchyInterface $hierarchy */
        $hierarchy = parent::find($id);

        if ($hierarchy === null) {
            throw new HierarchyNotFoundException("Cannot find type with id $id");
        }

        return $hierarchy;
    }
//endregion Find Filters Repository
}