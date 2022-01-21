<?php

namespace Evrinoma\ContractBundle\Tests\Functional\Helper;

trait BaseContractTestTrait
{
    protected function createContract(): array
    {
        $query = static::getDefault();

        return $this->post($query);
    }
}
