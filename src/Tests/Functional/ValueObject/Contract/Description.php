<?php

namespace Evrinoma\ContractBundle\Tests\Functional\ValueObject\Contract;

use Evrinoma\TestUtilsBundle\ValueObject\Common\AbstractIdentity;

class Description extends AbstractIdentity
{
//region SECTION: Fields
    protected static string $value = "description";

//endregion Fields
    public static function valueOwn(): string
    {
        return static::value().'0';
    }
}