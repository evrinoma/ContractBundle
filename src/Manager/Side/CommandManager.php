<?php

namespace Evrinoma\ContractBundle\Manager\Side;

use Evrinoma\ContractBundle\Dto\SideApiDtoInterface;
use Evrinoma\ContractBundle\Exception\Side\SideCannotBeCreatedException;
use Evrinoma\ContractBundle\Exception\Side\SideCannotBeRemovedException;
use Evrinoma\ContractBundle\Exception\Side\SideCannotBeSavedException;
use Evrinoma\ContractBundle\Exception\Side\SideInvalidException;
use Evrinoma\ContractBundle\Exception\Side\SideNotFoundException;
use Evrinoma\ContractBundle\Factory\SideFactoryInterface;
use Evrinoma\ContractBundle\Mediator\Side\CommandMediatorInterface;
use Evrinoma\ContractBundle\Model\Side\SideInterface;
use Evrinoma\ContractBundle\Repository\Side\SideCommandRepositoryInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;
use Evrinoma\UtilsBundle\Rest\RestTrait;
use Evrinoma\UtilsBundle\Validator\ValidatorInterface;
use Evrinoma\ContractBundle\Manager\Contract\QueryManagerInterface as ContractQueryManagerInterface;

final class CommandManager implements CommandManagerInterface, RestInterface
{
    use RestTrait;

//region SECTION: Fields
    private SideCommandRepositoryInterface $repository;
    private ValidatorInterface             $validator;
    private SideFactoryInterface           $factory;
    private CommandMediatorInterface       $mediator;
    private ContractQueryManagerInterface  $contractQueryManager;
//endregion Fields

//region SECTION: Constructor
    /**
     * @param ValidatorInterface             $validator
     * @param SideCommandRepositoryInterface $repository
     * @param SideFactoryInterface           $factory
     * @param CommandMediatorInterface       $mediator
     * @param ContractQueryManagerInterface  $contractQueryManager
     */
    public function __construct(ValidatorInterface $validator, SideCommandRepositoryInterface $repository, SideFactoryInterface $factory, CommandMediatorInterface $mediator, ContractQueryManagerInterface $contractQueryManager)
    {
        $this->validator            = $validator;
        $this->repository           = $repository;
        $this->factory              = $factory;
        $this->mediator             = $mediator;
        $this->contractQueryManager = $contractQueryManager;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @param SideApiDtoInterface $dto
     *
     * @return SideInterface
     * @throws SideInvalidException
     * @throws SideCannotBeCreatedException
     * @throws SideCannotBeSavedException
     */
    public function post(SideApiDtoInterface $dto): SideInterface
    {
        $side = $this->factory->create($dto);

        $this->mediator->onCreate($dto, $side);

        try {
            if ($dto->hasLeft()) {
                $side->setLeft($this->contractQueryManager->proxy($dto->getLeft()));
            }
        } catch (\Exception $e) {
            throw new SideCannotBeCreatedException($e->getMessage());
        }

        try {
            if ($dto->hasRight()) {
                $side->setRight($this->contractQueryManager->proxy($dto->getRight()));
            }
        } catch (\Exception $e) {
            throw new SideCannotBeCreatedException($e->getMessage());
        }

        $errors = $this->validator->validate($side);

        if (count($errors) > 0) {

            $errorsString = (string)$errors;

            throw new SideInvalidException($errorsString);
        }

        $this->repository->save($side);

        return $side;
    }

    /**
     * @param SideApiDtoInterface $dto
     *
     * @return SideInterface
     * @throws SideInvalidException
     * @throws SideNotFoundException
     * @throws SideCannotBeSavedException
     */
    public function put(SideApiDtoInterface $dto): SideInterface
    {
        try {
            $side = $this->repository->find($dto->getId());
        } catch (SideNotFoundException $e) {
            throw $e;
        }

        try {
            if ($dto->hasLeft()) {
                $side->setLeft($this->contractQueryManager->proxy($dto->getLeft()));
            } else {
                $side->resetLeft();
            }
        } catch (\Exception $e) {
            throw new SideCannotBeSavedException($e->getMessage());
        }

        try {
            if ($dto->hasRight()) {
                $side->setRight($this->contractQueryManager->proxy($dto->getRight()));
            } else {
                $side->resetRight();
            }
        } catch (\Exception $e) {
            throw new SideCannotBeSavedException($e->getMessage());
        }

        $this->mediator->onUpdate($dto, $side);

        $errors = $this->validator->validate($side);

        if (count($errors) > 0) {

            $errorsString = (string)$errors;

            throw new SideInvalidException($errorsString);
        }

        $this->repository->save($side);

        return $side;
    }

    /**
     * @param SideApiDtoInterface $dto
     *
     * @throws SideCannotBeRemovedException
     * @throws SideNotFoundException
     */
    public function delete(SideApiDtoInterface $dto): void
    {
        try {
            $side = $this->repository->find($dto->getId());
        } catch (SideNotFoundException $e) {
            throw $e;
        }
        $this->mediator->onDelete($dto, $side);
        try {
            $this->repository->remove($side);
        } catch (SideCannotBeRemovedException $e) {
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