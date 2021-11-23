<?php

namespace Evrinoma\ContractBundle\Repository\Contract;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMInvalidArgumentException;
use Evrinoma\ContractBundle\Dto\ContractApiDtoInterface;
use Evrinoma\ContractBundle\Exception\Contract\ContractCannotBeRemovedException;
use Evrinoma\ContractBundle\Exception\Contract\ContractCannotBeSavedException;
use Evrinoma\ContractBundle\Exception\Contract\ContractNotFoundException;
use Evrinoma\ContractBundle\Exception\Contract\ContractProxyException;
use Evrinoma\ContractBundle\Model\Contract\ContractInterface;

class ContractRepository extends ServiceEntityRepository implements ContractRepositoryInterface
{

//region SECTION: Public
    public function save(ContractInterface $contract): bool
    {
        try {
            $this->getEntityManager()->persist($contract);
        } catch (ORMInvalidArgumentException $e) {
            throw new ContractCannotBeSavedException($e->getMessage());
        }

        return true;
    }

    public function remove(ContractInterface $contract): bool
    {
        try {
            $this->getEntityManager()->remove($contract);
        } catch (ORMInvalidArgumentException $e) {
            throw new ContractCannotBeRemovedException($e->getMessage());
        }

        return true;
    }

    public function proxy(string $id): ContractInterface
    {
        $em = $this->getEntityManager();

        $contract = $em->getReference($this->getEntityName(), $id);

        if (!$em->contains($contract)) {
            throw new ContractProxyException("Proxy doesn't exist with $id");
        }

        return $contract;
    }
//endregion Public

//region SECTION: Find Filters Repository
    public function findByCriteria(ContractApiDtoInterface $dto): array
    {
        $builder = $this->createQueryBuilder('contract');

        if ($dto->hasName()) {
            $builder
                ->andWhere('contract.name like :name')
                ->setParameter('name', '%'.$dto->getName().'%');
        }

        $contract = $builder->getQuery()->getResult();

        if (count($contract) === 0) {
            throw new ContractNotFoundException("Cannot find contract by findByCriteria");
        }

        return $contract;
    }

    public function find($id, $lockMode = null, $lockVersion = null): ContractInterface
    {
        /** @var ContractInterface $contract */
        $contract = parent::find($id);

        if ($contract === null) {
            throw new ContractNotFoundException("Cannot find contract with id $id");
        }

        return $contract;
    }
//endregion Find Filters Repository
}