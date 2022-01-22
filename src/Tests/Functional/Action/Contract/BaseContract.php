<?php

namespace Evrinoma\ContractBundle\Tests\Functional\Action\Contract;

use Evrinoma\ContractBundle\Dto\ContractApiDto;
use Evrinoma\ContractBundle\Tests\Functional\Action\Type\BaseType;
use Evrinoma\ContractBundle\Tests\Functional\Action\Hierarchy\BaseHierarchy;
use Evrinoma\ContractBundle\Tests\Functional\Helper\BaseContractTestTrait;
use Evrinoma\ContractBundle\Tests\Functional\ValueObject\Contract\Description;
use Evrinoma\ContractBundle\Tests\Functional\ValueObject\Contract\Number;
use Evrinoma\ContractBundle\Tests\Functional\ValueObject\Type\Id as TypeId;
use Evrinoma\ContractBundle\Tests\Functional\ValueObject\Type\Identity as TypeIdentity;
use Evrinoma\ContractBundle\Tests\Functional\ValueObject\Contract\Id;
use Evrinoma\ContractBundle\Tests\Functional\ValueObject\Contract\Name;
use Evrinoma\TestUtilsBundle\Action\AbstractServiceTest;
use Evrinoma\UtilsBundle\Model\ActiveModel;
use PHPUnit\Framework\Assert;

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
        $this->post(static::getDefault(["description" => Description::empty(),]));
        $this->testResponseStatusUnprocessable();
        $this->post(static::getDefault(["name" => Name::empty(),]));
        $this->testResponseStatusUnprocessable();
        $this->post(static::getDefault(["type" => [],]));
        $this->testResponseStatusUnprocessable();
        $this->post(static::getDefault(["hierarchy" => [],]));
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
        $this->createContract();
        $this->testResponseStatusCreated();

        $this->createContract();
        $this->testResponseStatusConflict();
    }

    public function actionPutUnprocessable(): void
    {
        $this->put(static::getDefault(['id' => Id::empty()]));
        $this->testResponseStatusUnprocessable();
        $this->put(static::getDefault(["description" => Description::empty(),]));
        $this->testResponseStatusUnprocessable();
        $this->put(static::getDefault(["name" => Name::empty(),]));
        $this->testResponseStatusUnprocessable();
        $this->put(static::getDefault(["type" => [],]));
        $this->testResponseStatusUnprocessable();
        $this->put(static::getDefault(["hierarchy" => [],]));
        $this->testResponseStatusUnprocessable();
    }

    public function actionCriteria(): void
    {
        $this->createContract();
        $this->testResponseStatusCreated();

        $query    = static::getDefault(['id' => Id::empty(), 'name' => Name::value()]);
        $response = $this->criteria($query);

        Assert::assertArrayHasKey('data', $response);
        Assert::assertCount(1, $response['data']);

        $query    = static::getDefault(["type" => [], "hierarchy" => [], 'id' => Id::empty(), 'name' => Name::valueOwn(), 'description' => Description::valueOwn(), 'number' => Number::empty(),]);
        $response = $this->criteria($query);

        Assert::assertArrayHasKey('data', $response);
        Assert::assertCount(36, $response['data']);

        $query    = static::getDefault([
            "type"        => [],
            "hierarchy"   => [],
            'id'          => Id::empty(),
            'name'        => Name::valueOwn(),
            'description' => Description::valueOwn(),
            'number'      => Number::empty(),
        ]);
        $response = $this->criteria($query);

        Assert::assertArrayHasKey('data', $response);
        Assert::assertCount(36, $response['data']);

        $query    = static::getDefault([
                "type"        => self::merge(BaseType::defaultData(), ['identity' => TypeIdentity::empty()]),
                "hierarchy"   => self::merge(BaseHierarchy::defaultData(), ['identity' => TypeIdentity::empty()]),
                'id'          => Id::empty(),
                'name'        => Name::valueOwn(),
                'description' => Description::valueOwn(),
                'number'      => Number::empty(),
            ]
        );
        $response = $this->criteria($query);

        Assert::assertArrayHasKey('data', $response);
        Assert::assertCount(1, $response['data']);
        $query    = static::getDefault([
                "type"        => self::merge(BaseType::defaultData(), ['id' => TypeId::empty()]),
                "hierarchy"   => self::merge(BaseHierarchy::defaultData(), ['id' => TypeId::empty()]),
                'id'          => Id::empty(),
                'name'        => Name::valueOwn(),
                'description' => Description::valueOwn(),
                'number'      => Number::empty(),
            ]
        );
        $response = $this->criteria($query);

        Assert::assertArrayHasKey('data', $response);
        Assert::assertCount(1, $response['data']);
    }

    public function actionCriteriaNotFound(): void
    {
        $query    = static::getDefault(['id' => Id::empty(), 'name' => Name::wrong()]);
        $response = $this->criteria($query);

        Assert::assertArrayHasKey('data', $response);
        $this->testResponseStatusNotFound();
    }

    public function actionDelete(): void
    {
        $this->createContract();
        $this->testResponseStatusCreated();

        $query    = static::getDefault(['id' => Id::empty(), 'name' => Name::value()]);
        $response = $this->criteria($query);

        Assert::assertArrayHasKey('data', $response);
        Assert::assertCount(1, $response['data']);

        $id = $response['data'][0]['id'];

        $this->delete($id);
        $this->testResponseStatusAccepted();

        $response = $this->get($id);
        $this->testResponseStatusOK();

        Assert::assertArrayHasKey('data', $response);
        Assert::assertEquals($response['data']['active'], ActiveModel::DELETED);
    }

    public function actionGet(): void
    {
        $created = $this->createContract();
        $this->testResponseStatusCreated();

        $criteria = $this->get($created['data']['id']);
        Assert::assertArrayHasKey('data', $criteria);

        $find = $this->get($criteria['data']['id']);
        Assert::assertTrue($created['data'] == $find['data']);
    }

    public function actionPut(): void
    {
        $created = $this->createContract();
        $this->testResponseStatusCreated();

        $id = $created['data']['id'];

        $query   = static::getDefault([
                "type"        => ['id' => 2],
                "hierarchy"   => ['id' => 2],
                'id'          => $id,
                'name'        => Name::value(),
                'description' => Description::value(),
            ]
        );
        $updated = $this->put($query);
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey('data', $updated);

        $criteria = $this->get($id);
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey('data', $criteria);

        Assert::assertTrue($criteria['data'] == $updated['data']);
    }

    public function actionPutNotFound(): void
    {
        $this->createContract();
        $this->testResponseStatusCreated();

        $query    = static::getDefault(['id' => Id::empty(), 'name' => Name::value()]);
        $response = $this->criteria($query);

        Assert::assertArrayHasKey('data', $response);
        Assert::assertCount(1, $response['data']);

        $id = $response['data'][0]['id'];

        $this->delete($id);
        $this->testResponseStatusAccepted();

        $response = $this->get($id);
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey('data', $response);
        Assert::assertEquals($response['data']['active'], ActiveModel::DELETED);
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
            "class"       => static::getDtoClass(),
            "type"        => BaseType::defaultData(),
            "hierarchy"   => BaseHierarchy::defaultData(),
            "id"          => Id::value(),
            "name"        => Name::value(),
            "number"      => Number::value(),
            "description" => Description::value(),
            "active"      => ActiveModel::ACTIVE,
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