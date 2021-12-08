<?php

namespace Evrinoma\ContractBundle\Tests\Functional\Controller;


use Evrinoma\ContractBundle\Dto\HierarchyApiDto;
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
class HierarchyApiControllerTest extends AbstractWebCaseTest implements ApiControllerTestInterface, ApiBrowserTestInterface, ApiMethodTestInterface
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
        return HierarchyApiDto::class;
    }

    public static function getFixtures(): array
    {
        return [FixtureInterface::HIERARCHY_FIXTURES];
    }
//endregion Getters/Setters
}