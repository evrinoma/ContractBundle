<?php

namespace Evrinoma\ContractBundle\Repository\Side;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMInvalidArgumentException;
use Evrinoma\ContractBundle\Dto\SideApiDtoInterface;
use Evrinoma\ContractBundle\Exception\Side\SideCannotBeRemovedException;
use Evrinoma\ContractBundle\Exception\Side\SideCannotBeSavedException;
use Evrinoma\ContractBundle\Exception\Side\SideNotFoundException;
use Evrinoma\ContractBundle\Exception\Side\SideProxyException;
use Evrinoma\ContractBundle\Model\Side\SideInterface;

class SideRepository extends ServiceEntityRepository implements SideRepositoryInterface
{

//region SECTION: Public
    public function save(SideInterface $side): bool
    {
        try {
            $this->getEntityManager()->persist($side);
        } catch (ORMInvalidArgumentException $e) {
            throw new SideCannotBeSavedException($e->getMessage());
        }

        return true;
    }

    public function remove(SideInterface $side): bool
    {
        try {
            $this->getEntityManager()->remove($side);
        } catch (ORMInvalidArgumentException $e) {
            throw new SideCannotBeRemovedException($e->getMessage());
        }

        return true;
    }

    public function proxy(string $id): SideInterface
    {
        $em = $this->getEntityManager();

        $side = $em->getReference($this->getEntityName(), $id);

        if (!$em->contains($side)) {
            throw new SideProxyException("Proxy doesn't exist with $id");
        }

        return $side;
    }
//endregion Public

//region SECTION: Find Filters Repository
    public function findByCriteria(SideApiDtoInterface $dto): array
    {
        $builder = $this->createQueryBuilder('type');

        if ($dto->hasIdentity()) {
            $builder
                ->andWhere('type.identity like :identity')
                ->setParameter('identity', '%'.$dto->getIdentity().'%');
        }

        $side = $builder->getQuery()->getResult();

        if (count($side) === 0) {
            throw new SideNotFoundException("Cannot find type by findByCriteria");
        }

        return $side;
    }

    public function find($id, $lockMode = null, $lockVersion = null): SideInterface
    {
        /** @var SideInterface $side */
        $side = parent::find($id);

        if ($side === null) {
            throw new SideNotFoundException("Cannot find type with id $id");
        }

        return $side;
    }
//endregion Find Filters Repository
}