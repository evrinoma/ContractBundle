<?php

namespace Evrinoma\ContractBundle\Tests\Functional\Helper;


use Evrinoma\ContractBundle\Tests\Functional\ValueObject\Hierarchy\Identity;

trait BaseHierarchyTestTrait
{
//region SECTION: Protected
    protected function createHierarchy(): array
    {
        $query = static::getDefault(['identity' => Identity::valueOwn()]);

        return $this->post($query);
    }
//endregion Protected
}