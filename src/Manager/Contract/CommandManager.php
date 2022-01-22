<?php

namespace Evrinoma\ContractBundle\Manager\Contract;

use Evrinoma\ContractBundle\Dto\ContractApiDtoInterface;
use Evrinoma\ContractBundle\Exception\Contract\ContractCannotBeCreatedException;
use Evrinoma\ContractBundle\Exception\Contract\ContractCannotBeRemovedException;
use Evrinoma\ContractBundle\Exception\Contract\ContractCannotBeSavedException;
use Evrinoma\ContractBundle\Exception\Contract\ContractInvalidException;
use Evrinoma\ContractBundle\Exception\Contract\ContractNotFoundException;
use Evrinoma\ContractBundle\Factory\ContractFactoryInterface;
use Evrinoma\ContractBundle\Manager\Hierarchy\QueryManagerInterface as HierarchyQueryManagerInterface;
use Evrinoma\ContractBundle\Manager\Type\QueryManagerInterface as TypeQueryManagerInterface;
use Evrinoma\ContractBundle\Mediator\Contract\CommandMediatorInterface;
use Evrinoma\ContractBundle\Model\Contract\ContractInterface;
use Evrinoma\ContractBundle\Model\Define\HierarchyInterface;
use Evrinoma\ContractBundle\Model\Define\TypeInterface;
use Evrinoma\ContractBundle\Repository\Contract\ContractCommandRepositoryInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;
use Evrinoma\UtilsBundle\Rest\RestTrait;
use Evrinoma\UtilsBundle\Validator\ValidatorInterface;

final class CommandManager implements CommandManagerInterface, RestInterface
{
    use RestTrait;

//region SECTION: Fields
    private ContractCommandRepositoryInterface $repository;
    private ValidatorInterface                 $validator;
    private ContractFactoryInterface           $factory;
    private TypeQueryManagerInterface          $typeQueryManager;
    private HierarchyQueryManagerInterface     $hierarchyQueryManager;
    private CommandMediatorInterface           $mediator;
//endregion Fields

//region SECTION: Constructor
    /**
     * @param ValidatorInterface                 $validator
     * @param ContractCommandRepositoryInterface $repository
     * @param ContractFactoryInterface           $factory
     * @param TypeQueryManagerInterface          $typeQueryManager
     * @param HierarchyQueryManagerInterface     $hierarchyQueryManager
     */
    public function __construct(ValidatorInterface $validator, ContractCommandRepositoryInterface $repository, ContractFactoryInterface $factory, CommandMediatorInterface $mediator, TypeQueryManagerInterface $typeQueryManager, HierarchyQueryManagerInterface $hierarchyQueryManager)
    {
        $this->validator             = $validator;
        $this->repository            = $repository;
        $this->factory               = $factory;
        $this->mediator              = $mediator;
        $this->typeQueryManager      = $typeQueryManager;
        $this->hierarchyQueryManager = $hierarchyQueryManager;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @param ContractApiDtoInterface $dto
     *
     * @return ContractInterface
     * @throws ContractInvalidException
     * @throws ContractCannotBeCreatedException
     * @throws ContractCannotBeSavedException
     */
    public function post(ContractApiDtoInterface $dto): ContractInterface
    {
        $contract = $this->factory->create($dto);

        $this->mediator->onCreate($dto, $contract);

        try {
            if ($dto->hasTypeApiDto()) {
                $contract->setType($this->typeQueryManager->proxy($dto->getTypeApiDto()));
            } else {
                throw new ContractInvalidException('The Dto isn\'t invalid');
            }
        } catch (ContractInvalidException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new ContractCannotBeCreatedException($e->getMessage());
        }

        try {
            if ($dto->hasHierarchyApiDto()) {
                $contract->setHierarchy($this->hierarchyQueryManager->proxy($dto->getHierarchyApiDto()));
            } else {
                throw new ContractInvalidException('The Dto isn\'t invalid');
            }
        } catch (ContractInvalidException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new ContractCannotBeCreatedException($e->getMessage());
        }

        $errors = $this->validator->validate($contract);

        if (count($errors) > 0) {

            $errorsString = (string)$errors;

            throw new ContractInvalidException($errorsString);
        }

        $this->repository->save($contract);

        return $contract;
    }

    /**
     * @param ContractApiDtoInterface $dto
     *
     * @return ContractInterface
     * @throws ContractInvalidException
     * @throws ContractNotFoundException
     * @throws ContractCannotBeSavedException
     */
    public function put(ContractApiDtoInterface $dto): ContractInterface
    {
        try {
            $contract = $this->repository->find($dto->getId());
        } catch (ContractNotFoundException $e) {
            throw $e;
        }

        try {
            if ($dto->hasTypeApiDto()) {
                $contract->setType($this->typeQueryManager->proxy($dto->getTypeApiDto()));
            } else {
                throw new ContractInvalidException('The Dto isn\'t invalid');
            }
        } catch (ContractInvalidException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new ContractCannotBeSavedException($e->getMessage());
        }

        try {
            if ($dto->hasHierarchyApiDto()) {
                $contract->setHierarchy($this->hierarchyQueryManager->proxy($dto->getHierarchyApiDto()));
            } else {
                throw new ContractInvalidException('The Dto isn\'t invalid');
            }
        } catch (ContractInvalidException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new ContractCannotBeSavedException($e->getMessage());
        }

        $contract
            ->setUpdatedAt(new \DateTimeImmutable())
            ->setActive($dto->getActive())
            ->setName($dto->getName())
            ->setNumber($dto->getNumber())
            ->setDescription($dto->getDescription());

        $this->mediator->onUpdate($dto, $contract);

        $errors = $this->validator->validate($contract);

        if (count($errors) > 0) {

            $errorsString = (string)$errors;

            throw new ContractInvalidException($errorsString);
        }

        $this->repository->save($contract);

        return $contract;
    }

    /**
     * @param ContractApiDtoInterface $dto
     *
     * @throws ContractCannotBeRemovedException
     * @throws ContractNotFoundException
     */
    public function delete(ContractApiDtoInterface $dto): void
    {
        try {
            $contract = $this->repository->find($dto->getId());
        } catch (ContractNotFoundException $e) {
            throw $e;
        }
        $this->mediator->onDelete($dto, $contract);
        try {
            $this->repository->remove($contract);
        } catch (ContractCannotBeRemovedException $e) {
            throw $e;
        }
    }
//endregion Public

//region SECTION: Getters/Setters
    public function getRestStatus(): int
    {
        return $this->status;
    }
//endregion Getters/Setters
}