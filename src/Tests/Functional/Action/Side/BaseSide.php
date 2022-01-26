<?php

namespace Evrinoma\ContractBundle\Tests\Functional\Action\Side;

use Evrinoma\ContractBundle\Dto\SideApiDto;
use Evrinoma\ContractBundle\Tests\Functional\Action\Contract\BaseContract;
use Evrinoma\ContractBundle\Tests\Functional\Helper\BaseSideTestTrait;
use Evrinoma\ContractBundle\Tests\Functional\ValueObject\Side\Id;
use Evrinoma\TestUtilsBundle\Action\AbstractServiceTest;
use Evrinoma\UtilsBundle\Model\ActiveModel;
use PHPUnit\Framework\Assert;

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

    public function actionPost(): void
    {
        $this->createLeftSide();
        $this->testResponseStatusCreated();
        $this->createRightSide();
        $this->testResponseStatusCreated();

        $this->createLeftSide();
        $this->testResponseStatusCreated();
        $this->createRightSide();
        $this->testResponseStatusCreated();
    }

    public function actionPostDuplicate(): void
    {
        $this->createWithLeftRightSide();
        $this->testResponseStatusUnprocessable();
        $this->createWithoutLeftRightSide();
        $this->testResponseStatusUnprocessable();
    }

    public function actionPutUnprocessable(): void
    {
        $leftCreated = $this->createLeftSide();
        $this->testResponseStatusCreated();
        Assert::assertArrayHasKey('data', $leftCreated);
        $query = static::getDefault(["right" => BaseContract::defaultData(), "id" => Id::empty(), "left" => []]);
        $this->put($query);
        $this->testResponseStatusUnprocessable();
    }

    public function actionCriteria(): void
    {
        $queryRight = static::getDefault(["right" => BaseContract::defaultData(), "left" => []]);
        $criteria   = $this->criteria($queryRight);
        Assert::assertArrayHasKey('data', $criteria);
        Assert::assertCount(3, $criteria['data']);

        $queryLeft = static::getDefault(["right" => [], "left" => BaseContract::defaultData()]);
        $criteria  = $this->criteria($queryLeft);
        Assert::assertArrayHasKey('data', $criteria);
        Assert::assertCount(3, $criteria['data']);
    }

    public function actionCriteriaNotFound(): void
    {
        $query    = static::getDefault(["right" => BaseContract::defaultData(), "left" => BaseContract::defaultData()]);
        $response = $this->criteria($query);
        Assert::assertArrayHasKey('data', $response);
        $this->testResponseStatusNotFound();
    }

    public function actionDelete(): void
    {
        $leftCreated = $this->createLeftSide();
        $this->testResponseStatusCreated();
        Assert::assertArrayHasKey('data', $leftCreated);
        $this->delete($leftCreated['data']['id']);
        $this->testResponseStatusAccepted();
    }

    public function actionGet(): void
    {
        $leftCreated = $this->createLeftSide();
        $this->testResponseStatusCreated();

        $find = $this->get($leftCreated['data']['id']);
        Assert::assertArrayHasKey('data', $leftCreated);
        Assert::assertTrue($leftCreated['data'] == $find['data']);

        $rightCreated = $this->createRightSide();
        $this->testResponseStatusCreated();
        $find = $this->get($rightCreated['data']['id']);
        Assert::assertArrayHasKey('data', $rightCreated);
        Assert::assertTrue($rightCreated['data'] == $find['data']);
    }

    public function actionPut(): void
    {
        $leftCreated = $this->createLeftSide();
        $this->testResponseStatusCreated();
        Assert::assertArrayHasKey('data', $leftCreated);
        $query        = static::getDefault(["right" => BaseContract::defaultData(), "id" => $leftCreated['data']['id'], "left" => []]);
        $rightUpdated = $this->put($query);
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey('data', $rightUpdated);
        $value          = $leftCreated['data'];
        $value["right"] = $value["left"];
        unset($value["left"]);
        Assert::assertTrue($value == $rightUpdated['data']);
    }

    public function actionPutNotFound(): void
    {
        $leftCreated = $this->createLeftSide();
        $this->testResponseStatusCreated();
        Assert::assertArrayHasKey('data', $leftCreated);
        $query = static::getDefault(["right" => BaseContract::defaultData(), "id" => Id::wrong(), "left" => []]);
        $this->put($query);
        $this->testResponseStatusNotFound();
    }

    public function actionDeleteNotFound(): void
    {
        $this->delete(Id::wrong());
        $this->testResponseStatusNotFound();
    }

    public function actionDeleteUnprocessable(): void
    {
        $this->delete(Id::empty());
        $this->testResponseStatusUnprocessable();
    }

    public function actionGetNotFound(): void
    {
        $this->get(Id::wrong());
        $this->testResponseStatusNotFound();
    }

    public static function defaultData(): array
    {
        return [
            "class" => static::getDtoClass(),
            "left"  => [],
            "right" => [],
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