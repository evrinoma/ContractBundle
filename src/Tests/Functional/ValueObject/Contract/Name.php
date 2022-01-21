<?php

namespace Evrinoma\ContractBundle\Tests\Functional\ValueObject\Contract;


use Evrinoma\TestUtilsBundle\ValueObject\Common\AbstractName;

class Name extends AbstractName
{
//region SECTION: Fields
    protected static string $value = "Test name";
//endregion Fields
}