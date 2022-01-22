<?php

namespace Evrinoma\ContractBundle\Tests\Functional\ValueObject\Contract;


use Evrinoma\TestUtilsBundle\ValueObject\Common\AbstractName;

class Name extends AbstractName
{
//region SECTION: Fields
    protected static string $value = "name";

//endregion Fields
    public static function value(): string
    {
        return "Test ".parent::value();
    }

    public static function valueOwn(): string
    {
        return static::$value.'00';
    }
}