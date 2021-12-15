<?php

namespace Evrinoma\ContractBundle\Tests\Functional\Action\Hierarchy;

use Evrinoma\ContractBundle\Dto\HierarchyApiDto;
use Evrinoma\ContractBundle\Tests\Functional\Helper\BaseHierarchyTestTrait;
use Evrinoma\ContractBundle\Tests\Functional\ValueObject\Hierarchy\Id;
use Evrinoma\ContractBundle\Tests\Functional\ValueObject\Hierarchy\Identity;
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
    public function actionPostUnprocessable(): void
    {
        $this->postWrong();
        $this->testResponseStatusUnprocessable();
    }
//testCriteria testGet testDelete testPutNotFound testPut
    public function actionPost(): void
    {
        $this->createHierarchy();
        $this->testResponseStatusCreated();
    }

    public function actionPostDuplicate(): void
    {
        $this->createHierarchy();
        $this->testResponseStatusCreated();

        $this->createHierarchy();
        $this->testResponseStatusConflict();
    }

    public function actionPutUnprocessable(): void
    {
        $query = static::getDefault(['id' => Id::empty()]);

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $this->createHierarchy();

        $query = static::getDefault(['identity' => Identity::empty()]);

        $this->put($query);
        $this->testResponseStatusUnprocessable();
    }

    public function actionCriteria(): void
    {
        $this->createHierarchy();
        $this->testResponseStatusCreated();

        $query    = static::getDefault(['identity' => Identity::value()]);
        $response = $this->criteria($query);

        Assert::assertArrayHasKey('data', $response);
        Assert::assertCount(2, $response['data']);
    }

    public function actionCriteriaNotFound(): void
    {
        $query    = static::getDefault(['identity' => Identity::wrong()]);
        $response = $this->criteria($query);

        Assert::assertArrayHasKey('data', $response);
        $this->testResponseStatusNotFound();
    }

    public function actionDelete(): void
    {
        $query    = static::getDefault(['identity' => Identity::value()]);
        $response = $this->criteria($query);
        Assert::assertArrayHasKey('data', $response);
        Assert::assertCount(1, $response['data']);

        $this->delete($response['data'][0]['id']);
        $this->testResponseStatusAccepted();

        $query = static::getDefault(['identity' => Identity::value()]);
        $this->criteria($query);
        $this->testResponseStatusNotFound();
    }

    public function actionGet(): void
    {
        $query    = static::getDefault(['identity' => Identity::value()]);
        $criteria = $this->criteria($query);
        Assert::assertArrayHasKey('data', $criteria);
        Assert::assertCount(1, $criteria['data']);

        $find = $this->get($criteria['data'][0]['id']);
        Assert::assertTrue($criteria['data'] [0] == $find['data']);
    }

    public function actionPut(): void
    {
        $query    = static::getDefault(['identity' => Identity::value()]);
        $criteria = $this->criteria($query);
        Assert::assertArrayHasKey('data', $criteria);
        Assert::assertCount(1, $criteria['data']);
        $value             = $criteria['data'][0];
        $value['identity'] = Identity::valueOwn();
        $query             = static::getDefault($value);
        $updated           = $this->put($query);
        $this->testResponseStatusOK();
        Assert::assertTrue($value == $updated['data']);
    }

    public function actionPutNotFound(): void
    {
        $query    = static::getDefault(['id' => Id::value()]);
        $response = $this->criteria($query);
        Assert::assertArrayHasKey('data', $response);
        Assert::assertCount(1, $response['data']);

        $this->delete($response['data'][0]['id']);
        $this->testResponseStatusAccepted();

        $query = static::getDefault($response['data'][0]);
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
            "class"    => static::getDtoClass(),
            "identity" => Identity::value(),
        ];
    }
//endregion Public

//region SECTION: Getters/Setters
    public static function getDtoClass(): string
    {
        return HierarchyApiDto::class;
    }
//endregion Getters/Setters
}