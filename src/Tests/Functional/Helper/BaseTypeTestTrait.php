<?php

namespace Evrinoma\ContractBundle\Tests\Functional\Helper;


use Evrinoma\ContractBundle\Tests\Functional\ValueObject\Type\Identity;

trait BaseTypeTestTrait
{
//region SECTION: Protected
    protected function createType(): array
    {
        $query = static::getDefault(['identity' => Identity::valueOwn()]);

        return $this->post($query);
    }
//endregion Protected
}