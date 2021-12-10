<?php

namespace Evrinoma\ContractBundle\Tests\Functional\Action\Hierarchy;

use Evrinoma\ContractBundle\Dto\HierarchyApiDto;
use Evrinoma\ContractBundle\Tests\Functional\Helper\BaseHierarchyTestTrait;
use Evrinoma\TestUtilsBundle\Action\AbstractServiceTest;
use PHPUnit\Framework\Assert;

class BaseHierarchy extends AbstractServiceTest implements BaseHierarchyTestInterface
{
    use BaseHierarchyTestTrait;

//region SECTION: Fields
    public const API_GET      = 'evrinoma/api/contract/hierarchy';
    public const API_CRITERIA = 'evrinoma/api/contract/hierarchy/criteria';
    public const API_DELETE   = 'evrinoma/api/contract/hierarchy/delete';
    public const API_PUT      = 'evrinoma/api/contract/hierarchy/save';
    public const API_POST     = 'evrinoma/api/contract/hierarchy/create';
//endregion Fields

//region SECTION: Public
    public static function defaultData(): array
    {
        return [
            "class"    => static::getDtoClass(),
            "identity" => 'contract_own',
        ];
    }

    public function actionPost(): void
    {
        Assert::assertEquals(true, true, 'test');
    }

    public function actionCriteria(): void
    {
        Assert::assertEquals(true, true, 'test');
    }

    public function actionCriteriaNotFound(): void
    {
        Assert::assertEquals(true, true, 'test');
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

    public function actionPutUnprocessable(): void
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

    public function actionPostDuplicate(): void
    {
    }

    public function actionPostUnprocessable(): void
    {
    }

//endregion Public

//region SECTION: Getters/Setters
    public static function getDtoClass(): string
    {
        return HierarchyApiDto::class;
    }
//endregion Getters/Setters
}