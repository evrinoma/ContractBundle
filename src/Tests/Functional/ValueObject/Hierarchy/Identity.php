<?php

namespace Evrinoma\ContractBundle\Tests\Functional\ValueObject\Hierarchy;

use Evrinoma\TestUtilsBundle\ValueObject\Common\AbstractIdentity;

class Identity extends AbstractIdentity
{
//region SECTION: Fields
    protected static string $value = "contract";
//endregion Fields

//region SECTION: Public
    public static function valueOwn(): string
    {
        return static::value().'_own';
    }
//endregion Public
}