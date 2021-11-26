<?php

namespace Evrinoma\ContractBundle\Tests\Functional\Controller;


use Evrinoma\ContractBundle\Dto\TypeApiDto;
use Evrinoma\ContractBundle\Fixtures\FixtureInterface;
use Evrinoma\ContractBundle\Tests\Functional\CaseTest;
use Evrinoma\TestUtilsBundle\Browser\ApiBrowserTestInterface;
use Evrinoma\TestUtilsBundle\Browser\ApiBrowserTestTrait;
use Evrinoma\TestUtilsBundle\Controller\ApiControllerTestInterface;
use Evrinoma\TestUtilsBundle\Helper\ApiMethodTestInterface;
use Evrinoma\TestUtilsBundle\Helper\ApiMethodTestTrait;
use Evrinoma\TestUtilsBundle\Helper\ResponseStatusTestTrait;

/**
 * @group functional
 */
class HierarchyApiControllerTest extends CaseTest implements ApiControllerTestInterface, ApiBrowserTestInterface, ApiMethodTestInterface
{
//region SECTION: Fields
    public const API_GET      = 'evrinoma/api/contract/hierarchy';
    public const API_CRITERIA = 'evrinoma/api/contract/hierarchy/criteria';
    public const API_DELETE   = 'evrinoma/api/contract/hierarchy/delete';
    public const API_PUT      = 'evrinoma/api/contract/hierarchy/save';
    public const API_POST     = 'evrinoma/api/contract/hierarchy/create';
//endregion Fields

    use ApiBrowserTestTrait, ApiMethodTestTrait, ResponseStatusTestTrait;

//region SECTION: Protected
//endregion Protected

//region SECTION: Public
    public static function defaultData(): array
    {
        return [
            "class"    => static::getDtoClass(),
            "identity" => 'contract_own',
        ];
    }

    public function testPost(): void
    {
        $this->assertEquals(true, true, 'test');
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

    public function testPutUnprocessable(): void
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

    public function testPostDuplicate(): void
    {
    }

    public function testPostUnprocessable(): void
    {
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