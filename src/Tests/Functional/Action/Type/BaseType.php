<?php

namespace Evrinoma\ContractBundle\Tests\Functional\Action\Type;

use Evrinoma\ContractBundle\Dto\TypeApiDto;
use Evrinoma\ContractBundle\Tests\Functional\Helper\BaseTypeTestTrait;
use Evrinoma\TestUtilsBundle\Action\AbstractServiceTest;
use PHPUnit\Framework\Assert;

class BaseType extends AbstractServiceTest implements BaseTypeTestInterface
{
    use BaseTypeTestTrait;

//region SECTION: Fields
    public const API_GET      = 'evrinoma/api/contract/type';
    public const API_CRITERIA = 'evrinoma/api/contract/type/criteria';
    public const API_DELETE   = 'evrinoma/api/contract/type/delete';
    public const API_PUT      = 'evrinoma/api/contract/type/save';
    public const API_POST     = 'evrinoma/api/contract/type/create';
//endregion Fields


//region SECTION: Public
    public function actionPostUnprocessable(): void
    {
        $this->postWrong();
        $this->testResponseStatusUnprocessable();
    }


    public function actionPost(): void
    {
        $this->createType();
        $this->testResponseStatusCreated();
    }

    public function actionPostDuplicate(): void
    {
        $this->createType();
        $this->testResponseStatusCreated();

        $this->createType();
        $this->testResponseStatusConflict();
    }

    public function actionPutUnprocessable(): void
    {
        $query = static::getDefault(['id' => '']);

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $this->createType();

        $query = static::getDefault(['identity' => '']);

        $this->put($query);
        $this->testResponseStatusUnprocessable();
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
            "class"    => static::getDtoClass(),
            "identity" => 'main_income_own',
        ];
    }
//endregion Public

//region SECTION: Getters/Setters
    public static function getDtoClass(): string
    {
        return TypeApiDto::class;
    }
//endregion Getters/Setters

}