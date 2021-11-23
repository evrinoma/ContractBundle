<?php

namespace Evrinoma\ContractBundle\Repository\Side;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Doctrine\Persistence\ManagerRegistry;
use Evrinoma\ContractBundle\Exception\Side\SideCannotBeRemovedException;
use Evrinoma\ContractBundle\Exception\Side\SideProxyException;
use Evrinoma\ContractBundle\Mediator\Side\QueryMediatorInterface;
use Evrinoma\ContractBundle\Dto\SideApiDtoInterface;
use Evrinoma\ContractBundle\Exception\Side\SideCannotBeSavedException;
use Evrinoma\ContractBundle\Exception\Side\SideNotFoundException;
use Evrinoma\ContractBundle\Model\Side\SideInterface;

class SideRepository extends ServiceEntityRepository implements SideRepositoryInterface
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
     * @param SideInterface $side
     *
     * @return bool
     * @throws SideCannotBeSavedException
     * @throws ORMException
     */
    public function save(SideInterface $side): bool
    {
        try {
            $this->getEntityManager()->persist($side);
        } catch (ORMInvalidArgumentException $e) {
            throw new SideCannotBeSavedException($e->getMessage());
        }

        return true;
    }

    /**
     * @param SideInterface $side
     *
     * @return bool
     * @throws ORMException
     * @throws SideCannotBeRemovedException
     */
    public function remove(SideInterface $side): bool
    {
        try {
            $this->getEntityManager()->remove($side);
        } catch (ORMInvalidArgumentException $e) {
            throw new SideCannotBeRemovedException($e->getMessage());
        }

        return true;
    }
//endregion Public

//region SECTION: Find Filters Repository
    /**
     * @param SideApiDtoInterface $dto
     *
     * @return array
     * @throws SideNotFoundException
     */
    public function findByCriteria(SideApiDtoInterface $dto): array
    {
        $builder = $this->createQueryBuilder($this->mediator->alias());

        $this->mediator->createQuery($dto, $builder);

        $sides = $this->mediator->getResult($dto, $builder);

        if (count($sides) === 0) {
            throw new SideNotFoundException("Cannot find side by findByCriteria");
        }

        return $sides;
    }

    /**
     * @param      $id
     * @param null $lockMode
     * @param null $lockVersion
     *
     * @return mixed
     * @throws SideNotFoundException
     */
    public function find($id, $lockMode = null, $lockVersion = null): SideInterface
    {
        /** @var SideInterface $side */
        $side = parent::find($id);

        if ($side === null) {
            throw new SideNotFoundException("Cannot find side with id $id");
        }

        return $side;
    }

    /**
     * @param string $id
     *
     * @return SideInterface
     * @throws SideProxyException
     * @throws ORMException
     */
    public function proxy(string $id): SideInterface
    {
        $em = $this->getEntityManager();

        $side = $em->getReference($this->getEntityName(), $id);

        if (!$em->contains($side)) {
            throw new SideProxyException("Proxy doesn't exist with $id");
        }

        return $side;
    }
//endregion Find Filters Repository

}