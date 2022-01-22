<?php

namespace Evrinoma\ContractBundle\Tests\Functional\ValueObject\Contract;


use Evrinoma\TestUtilsBundle\ValueObject\Common\AbstractName;

class Number extends AbstractName
{
//region SECTION: Fields
    protected static string $value = "0";

//endregion Fields
    public static function valueOwn(): string
    {
        return static::$value.'00';
    }
}