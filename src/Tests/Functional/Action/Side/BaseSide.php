<?php

namespace Evrinoma\ContractBundle\Tests\Functional\Action\Side;

use Evrinoma\ContractBundle\Dto\SideApiDto;
use Evrinoma\ContractBundle\Tests\Functional\Action\Contract\BaseContract;
use Evrinoma\ContractBundle\Tests\Functional\Helper\BaseSideTestTrait;
use Evrinoma\TestUtilsBundle\Action\AbstractServiceTest;

class BaseSide extends AbstractServiceTest implements BaseSideTestInterface
{
    use BaseSideTestTrait;

//region SECTION: Fields
    public const API_GET      = 'evrinoma/api/contract/side';
    public const API_CRITERIA = 'evrinoma/api/contract/side/criteria';
    public const API_DELETE   = 'evrinoma/api/contract/side/delete';
    public const API_PUT      = 'evrinoma/api/contract/side/save';
    public const API_POST     = 'evrinoma/api/contract/side/create';
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
            "class" => static::getDtoClass(),
            "left"  => [BaseContract::defaultData(),],
            "right" => [BaseContract::defaultData(),],
        ];
    }
//endregion Public

//region SECTION: Getters/Setters
    public static function getDtoClass(): string
    {
        return SideApiDto::class;
    }
//endregion Getters/Setters
}