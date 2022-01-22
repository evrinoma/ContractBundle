<?php

namespace Evrinoma\ContractBundle\Repository\Contract;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Doctrine\Persistence\ManagerRegistry;
use Evrinoma\ContractBundle\Exception\Contract\ContractProxyException;
use Evrinoma\ContractBundle\Mediator\Contract\QueryMediatorInterface;
use Evrinoma\ContractBundle\Dto\ContractApiDtoInterface;
use Evrinoma\ContractBundle\Exception\Contract\ContractCannotBeSavedException;
use Evrinoma\ContractBundle\Exception\Contract\ContractNotFoundException;
use Evrinoma\ContractBundle\Model\Contract\ContractInterface;

class ContractRepository extends ServiceEntityRepository implements ContractRepositoryInterface
{
//region SECTION: Fields
    private QueryMediatorInterface $mediator;
//endregion Fields

//region SECTION: Constructor
    /**
     * @param ManagerRegistry        $registry
     * @param string                 $entityClass
     * @param QueryMediatorInterface $mediator
     */
    public function __construct(ManagerRegistry $registry, string $entityClass, QueryMediatorInterface $mediator)
    {
        parent::__construct($registry, $entityClass);
        $this->mediator = $mediator;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @param ContractInterface $contract
     *
     * @return bool
     * @throws ContractCannotBeSavedException
     * @throws ORMException
     */
    public function save(ContractInterface $contract): bool
    {
        try {
            $this->getEntityManager()->persist($contract);
        } catch (ORMInvalidArgumentException $e) {
            throw new ContractCannotBeSavedException($e->getMessage());
        }

        return true;
    }

    /**
     * @param ContractInterface $contract
     *
     * @return bool
     */
    public function remove(ContractInterface $contract): bool
    {
        $contract
            ->setUpdatedAt(new \DateTimeImmutable())
            ->setActiveToDelete();

        return true;
    }
//endregion Public

//region SECTION: Find Filters Repository
    /**
     * @param ContractApiDtoInterface $dto
     *
     * @return array
     * @throws ContractNotFoundException
     */
    public function findByCriteria(ContractApiDtoInterface $dto): array
    {
        $builder = $this->createQueryBuilder($this->mediator->alias());

        $this->mediator->createQuery($dto, $builder);

        $contractes = $this->mediator->getResult($dto, $builder);

        if (count($contractes) === 0) {
            throw new ContractNotFoundException("Cannot find contract by findByCriteria");
        }

        return $contractes;
    }

    /**
     * @param      $id
     * @param null $lockMode
     * @param null $lockVersion
     *
     * @return mixed
     * @throws ContractNotFoundException
     */
    public function find($id, $lockMode = null, $lockVersion = null): ContractInterface
    {
        /** @var ContractInterface $contract */
        $contract = parent::find($id);

        if ($contract === null) {
            throw new ContractNotFoundException("Cannot find contract with id $id");
        }

        return $contract;
    }

    /**
     * @param string $id
     *
     * @return ContractInterface
     * @throws ContractProxyException
     * @throws ORMException
     */
    public function proxy(string $id): ContractInterface
    {
        $em = $this->getEntityManager();

        $contract = $em->getReference($this->getEntityName(), $id);

        if (!$em->contains($contract)) {
            throw new ContractProxyException("Proxy doesn't exist with $id");
        }

        return $contract;
    }
//endregion Find Filters Repository

}