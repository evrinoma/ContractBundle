<?php


namespace Evrinoma\ContractBundle\Validator;


use Evrinoma\ContractBundle\Entity\Define\BaseHierarchy;
use Evrinoma\UtilsBundle\Validator\AbstractValidator;

final class HierarchyValidator extends AbstractValidator
{
//region SECTION: Fields
    /**
     * @var string|null
     */
    protected static ?string $entityClass = BaseHierarchy::class;
//endregion Fields

//region SECTION: Constructor
    public function __construct()
    {
        parent::__construct(self::$entityClass);
    }
//endregion Constructor
}