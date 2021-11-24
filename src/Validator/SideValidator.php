<?php


namespace Evrinoma\ContractBundle\Validator;

use Evrinoma\ContractBundle\Entity\Side\BaseSide;
use Evrinoma\UtilsBundle\Validator\AbstractValidator;

final class SideValidator extends AbstractValidator
{
//region SECTION: Fields
    /**
     * @var string|null
     */
    protected static ?string $entityClass = BaseSide::class;
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