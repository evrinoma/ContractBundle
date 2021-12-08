<?php

namespace Evrinoma\ContractBundle\Tests\Functional\Controller;


use Evrinoma\ContractBundle\Dto\TypeApiDto;
use Evrinoma\ContractBundle\Fixtures\FixtureInterface;
use Evrinoma\TestUtilsBundle\Browser\ApiBrowserTestInterface;
use Evrinoma\TestUtilsBundle\Browser\ApiBrowserTestTrait;
use Evrinoma\TestUtilsBundle\Controller\ApiControllerTestInterface;
use Evrinoma\TestUtilsBundle\Helper\ApiMethodTestInterface;
use Evrinoma\TestUtilsBundle\Helper\ApiMethodTestTrait;
use Evrinoma\TestUtilsBundle\Helper\ResponseStatusTestTrait;
use Evrinoma\TestUtilsBundle\Web\AbstractWebCaseTest;

/**
 * @group functional
 */
class TypeApiControllerTest extends AbstractWebCaseTest implements ApiControllerTestInterface, ApiBrowserTestInterface, ApiMethodTestInterface
{
//region SECTION: Fields
    public const API_GET      = 'evrinoma/api/contract/type';
    public const API_CRITERIA = 'evrinoma/api/contract/type/criteria';
    public const API_DELETE   = 'evrinoma/api/contract/type/delete';
    public const API_PUT      = 'evrinoma/api/contract/type/save';
    public const API_POST     = 'evrinoma/api/contract/type/create';
//endregion Fields

    use ApiBrowserTestTrait, ApiMethodTestTrait, ResponseStatusTestTrait;

//region SECTION: Protected
//endregion Protected

//region SECTION: Public
    public static function defaultData(): array
    {
        return [
            "class"    => static::getDtoClass(),
            "identity" => 'main_income_own',
        ];
    }

    public function testPostUnprocessable(): void
    {
        $this->postWrong();
        $this->testResponseStatusUnprocessable();
    }


    public function testPost(): void
    {
        $this->createType();
        $this->testResponseStatusCreated();
    }

    public function testPostDuplicate(): void
    {
        $this->createType();
        $this->testResponseStatusCreated();

        $this->createType();
        $this->testResponseStatusConflict();
    }

    public function testPutUnprocessable(): void
    {
        $query = static::getDefault(['id' => '']);

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $this->createType();

        $query = static::getDefault(['identity' => '']);

        $this->put($query);
        $this->testResponseStatusUnprocessable();
    }

    public function testCriteria(): void
    {
        $this->assertEquals(true, true, 'test');
    }

    public function testCriteriaNotFound(): void
    {
        $this->assertEquals(true, true, 'test');
    }

    public function testDelete(): void
    {
    }

    public function testGet(): void
    {
    }

    public function testPut(): void
    {
    }

    public function testPutNotFound(): void
    {
    }

    public function testDeleteNotFound(): void
    {
    }

    public function testDeleteUnprocessable(): void
    {

    }

    public function testGetNotFound(): void
    {
    }

    private function createTypeDuplicateIdentity(): array
    {
        $query = static::getDefault(['identity' => 'main_income']);

        return $this->post($query);
    }

    private function createType(): array
    {
        $query = static::getDefault();

        return $this->post($query);
    }

    private function createConstraintBlankId(): array
    {
        $query = static::getDefault(['id' => '']);

        return $this->post($query);
    }
//endregion Public

//region SECTION: Getters/Setters
    public static function getDtoClass(): string
    {
        return TypeApiDto::class;
    }

    public static function getFixtures(): array
    {
        return [FixtureInterface::TYPE_FIXTURES];
    }
//endregion Getters/Setters
}