<?php

namespace Evrinoma\ContractBundle\Manager\Type;

use Evrinoma\ContractBundle\Dto\TypeApiDtoInterface;
use Evrinoma\ContractBundle\Exception\Type\TypeCannotBeRemovedException;
use Evrinoma\ContractBundle\Exception\Type\TypeInvalidException;
use Evrinoma\ContractBundle\Exception\Type\TypeNotFoundException;
use Evrinoma\ContractBundle\Factory\TypeFactoryInterface;
use Evrinoma\ContractBundle\Model\Define\TypeInterface;
use Evrinoma\ContractBundle\Repository\Type\TypeCommandRepositoryInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;
use Evrinoma\UtilsBundle\Rest\RestTrait;
use Evrinoma\UtilsBundle\Validator\ValidatorInterface;

final class CommandManager implements CommandManagerInterface, RestInterface
{
    use RestTrait;

//region SECTION: Fields
    private TypeCommandRepositoryInterface $repository;
    private ValidatorInterface             $validator;
    private TypeFactoryInterface           $factory;
//endregion Fields

//region SECTION: Constructor
    /**
     * @param ValidatorInterface             $validator
     * @param TypeCommandRepositoryInterface $repository
     * @param TypeFactoryInterface           $factory
     */
    public function __construct(ValidatorInterface $validator, TypeCommandRepositoryInterface $repository, TypeFactoryInterface $factory)
    {
        $this->validator  = $validator;
        $this->repository = $repository;
        $this->factory    = $factory;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @param TypeApiDtoInterface $dto
     *
     * @return TypeInterface
     * @throws TypeInvalidException
     */
    public function post(TypeApiDtoInterface $dto): TypeInterface
    {
        $type = $this->factory->create($dto);

        $errors = $this->validator->validate($type);

        if (count($errors) > 0) {

            $errorsString = (string)$errors;

            throw new TypeInvalidException($errorsString);
        }

        $this->repository->save($type);

        return $type;
    }

    /**
     * @param TypeApiDtoInterface $dto
     *
     * @return TypeInterface
     * @throws TypeInvalidException
     * @throws TypeNotFoundException
     */
    public function put(TypeApiDtoInterface $dto): TypeInterface
    {
        try {
            $type = $this->repository->find($dto->getId());
        } catch (TypeNotFoundException $e) {
            throw $e;
        }

        $type->setIdentity($dto->getIdentity());

        $errors = $this->validator->validate($type);

        if (count($errors) > 0) {

            $errorsString = (string)$errors;

            throw new TypeInvalidException($errorsString);
        }

        $this->repository->save($type);

        return $type;
    }

    /**
     * @param TypeApiDtoInterface $dto
     *
     * @throws TypeCannotBeRemovedException
     * @throws TypeNotFoundException
     */
    public function delete(TypeApiDtoInterface $dto): void
    {
        try {
            $type = $this->repository->find($dto->getId());
        } catch (TypeNotFoundException $e) {
            throw $e;
        }
        try {
            $this->repository->remove($type);
        } catch (TypeCannotBeRemovedException $e) {
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