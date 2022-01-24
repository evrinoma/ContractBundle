<?php

namespace Evrinoma\ContractBundle\Tests\Functional\Helper;


use Evrinoma\ContractBundle\Tests\Functional\Action\Contract\BaseContract;

trait BaseSideTestTrait
{
    protected function createLeftSide(): array
    {
        $query = static::getDefault(["left" => BaseContract::defaultData(),]);

        return $this->post($query);
    }

    protected function createRightSide(): array
    {
        $query = static::getDefault(["right" => BaseContract::defaultData(),]);

        return $this->post($query);
    }
}

