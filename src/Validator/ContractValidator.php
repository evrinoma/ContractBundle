<?php


namespace Evrinoma\ContractBundle\Validator;

use Evrinoma\ContractBundle\Entity\Contract\BaseContract;
use Evrinoma\UtilsBundle\Validator\AbstractValidator;

final class ContractValidator extends AbstractValidator
{
//region SECTION: Fields
    /**
     * @var string|null
     */
    protected static ?string $entityClass = BaseContract::class;
//endregion Fields

//region SECTION: Constructor
    /**
     * @param string $entityClass
     */
    public function __construct(string $entityClass)
    {
        parent::__construct($entityClass);
    }
//endregion Constructor
}