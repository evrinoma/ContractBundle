<?php


namespace Evrinoma\ContractBundle\Validator;


use Evrinoma\ContractBundle\Entity\Define\BaseHierarchy;
use Evrinoma\UtilsBundle\Validator\AbstractValidator;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class HierarchyValidator extends AbstractValidator
{
//region SECTION: Fields
    /**
     * @var string|null
     */
    protected static ?string $entityClass = BaseHierarchy::class;
//endregion Fields

//region SECTION: Constructor
    /**
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        parent::__construct($validator, self::$entityClass);
    }
//endregion Constructor
}