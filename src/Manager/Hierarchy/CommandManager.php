<?php

namespace Evrinoma\ContractBundle\Manager\Hierarchy;

use Evrinoma\ContractBundle\Dto\HierarchyApiDtoInterface;
use Evrinoma\ContractBundle\Exception\Hierarchy\HierarchyCannotBeRemovedException;
use Evrinoma\ContractBundle\Exception\Hierarchy\HierarchyInvalidException;
use Evrinoma\ContractBundle\Exception\Hierarchy\HierarchyNotFoundException;
use Evrinoma\ContractBundle\Factory\HierarchyFactoryInterface;
use Evrinoma\ContractBundle\Model\Define\HierarchyInterface;
use Evrinoma\ContractBundle\Repository\Hierarchy\HierarchyCommandRepositoryInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;
use Evrinoma\UtilsBundle\Rest\RestTrait;
use Evrinoma\UtilsBundle\Validator\ValidatorInterface;

final class CommandManager implements CommandManagerInterface, RestInterface
{
    use RestTrait;

//region SECTION: Fields
    private HierarchyCommandRepositoryInterface $repository;
    private ValidatorInterface             $validator;
    private HierarchyFactoryInterface           $factory;
//endregion Fields

//region SECTION: Constructor
    /**
     * @param ValidatorInterface             $validator
     * @param HierarchyCommandRepositoryInterface $repository
     * @param HierarchyFactoryInterface           $factory
     */
    public function __construct(ValidatorInterface $validator, HierarchyCommandRepositoryInterface $repository, HierarchyFactoryInterface $factory)
    {
        $this->validator  = $validator;
        $this->repository = $repository;
        $this->factory    = $factory;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @param HierarchyApiDtoInterface $dto
     *
     * @return HierarchyInterface
     * @throws HierarchyInvalidException
     */
    public function post(HierarchyApiDtoInterface $dto): HierarchyInterface
    {
        $hierarchy = $this->factory->create($dto);

        $errors = $this->validator->validate($hierarchy);

        if (count($errors) > 0) {

            $errorsString = (string)$errors;

            throw new HierarchyInvalidException($errorsString);
        }

        $this->repository->save($hierarchy);

        return $hierarchy;
    }

    /**
     * @param HierarchyApiDtoInterface $dto
     *
     * @return HierarchyInterface
     * @throws HierarchyInvalidException
     * @throws HierarchyNotFoundException
     */
    public function put(HierarchyApiDtoInterface $dto): HierarchyInterface
    {
        try {
            $hierarchy = $this->repository->find($dto->getId());
        } catch (HierarchyNotFoundException $e) {
            throw $e;
        }

        $hierarchy->setBrief($dto->getBrief());

        $errors = $this->validator->validate($hierarchy);

        if (count($errors) > 0) {

            $errorsString = (string)$errors;

            throw new HierarchyInvalidException($errorsString);
        }

        $this->repository->save($hierarchy);

        return $hierarchy;
    }

    /**
     * @param HierarchyApiDtoInterface $dto
     *
     * @throws HierarchyCannotBeRemovedException
     * @throws HierarchyNotFoundException
     */
    public function delete(HierarchyApiDtoInterface $dto): void
    {
        try {
            $hierarchy = $this->repository->find($dto->getId());
        } catch (HierarchyNotFoundException $e) {
            throw $e;
        }
        try {
            $this->repository->remove($hierarchy);
        } catch (HierarchyCannotBeRemovedException $e) {
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