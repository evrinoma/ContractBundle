<?php

namespace Evrinoma\ContractBundle\Tests\Functional\Helper;


trait BaseTypeTestTrait
{
//region SECTION: Protected
    protected function createTypeDuplicateIdentity(): array
    {
        $query = static::getDefault(['identity' => 'main_income']);

        return $this->post($query);
    }

    protected function createType(): array
    {
        $query = static::getDefault();

        return $this->post($query);
    }

    protected function createConstraintBlankId(): array
    {
        $query = static::getDefault(['id' => '']);

        return $this->post($query);
    }
//endregion Protected
}