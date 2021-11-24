<?php


namespace Evrinoma\ContractBundle\Validator;


use Evrinoma\ContractBundle\Entity\Define\BaseType;
use Evrinoma\UtilsBundle\Validator\AbstractValidator;

final class TypeValidator extends AbstractValidator
{
//region SECTION: Fields
    /**
     * @var string|null
     */
    protected static ?string $entityClass = BaseType::class;
//endregion Fields

//region SECTION: Constructor
    public function __construct()
    {
        parent::__construct(self::$entityClass);
    }
//endregion Constructor
}