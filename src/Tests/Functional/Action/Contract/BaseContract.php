<?php

namespace Evrinoma\ContractBundle\Tests\Functional\Action\Contract;

use Evrinoma\ContractBundle\Dto\ContractApiDto;
use Evrinoma\ContractBundle\Tests\Functional\Action\Type\BaseType;
use Evrinoma\ContractBundle\Tests\Functional\Action\Hierarchy\BaseHierarchy;
use Evrinoma\ContractBundle\Tests\Functional\Helper\BaseContractTestTrait;
use Evrinoma\ContractBundle\Tests\Functional\ValueObject\Contract\Description;
use Evrinoma\ContractBundle\Tests\Functional\ValueObject\Contract\Id;
use Evrinoma\ContractBundle\Tests\Functional\ValueObject\Contract\Name;
use Evrinoma\TestUtilsBundle\Action\AbstractServiceTest;

class BaseContract extends AbstractServiceTest implements BaseContractTestInterface
{
    use BaseContractTestTrait;

//region SECTION: Fields
    public const API_GET      = 'evrinoma/api/contract';
    public const API_CRITERIA = 'evrinoma/api/contract/criteria';
    public const API_DELETE   = 'evrinoma/api/contract/delete';
    public const API_PUT      = 'evrinoma/api/contract/save';
    public const API_POST     = 'evrinoma/api/contract/create';
//endregion Fields

//region SECTION: Public
    public function actionPostUnprocessable(): void
    {
        $this->postWrong();
        $this->testResponseStatusUnprocessable();
    }

//testCriteria testGet testDelete testPutNotFound testPut
    public function actionPost(): void
    {
        $this->createContract();
        $this->testResponseStatusCreated();
    }

    public function actionPostDuplicate(): void
    {

    }

    public function actionPutUnprocessable(): void
    {

    }

    public function actionCriteria(): void
    {

    }

    public function actionCriteriaNotFound(): void
    {

    }

    public function actionDelete(): void
    {

    }

    public function actionGet(): void
    {

    }

    public function actionPut(): void
    {

    }

    public function actionPutNotFound(): void
    {

    }

    public function actionDeleteNotFound(): void
    {

    }

    public function actionDeleteUnprocessable(): void
    {

    }

    public function actionGetNotFound(): void
    {

    }

    public static function defaultData(): array
    {
        return [
            "class"       => static::getDtoClass(),
            "type"        => BaseType::defaultData(),
            "hierarchy"   => BaseHierarchy::defaultData(),
            "id"          => Id::value(),
            "name"        => Name::value(),
            "description" => Description::value(),
        ];
    }
//endregion Public

//region SECTION: Getters/Setters
    public static function getDtoClass(): string
    {
        return ContractApiDto::class;
    }
//endregion Getters/Setters
}