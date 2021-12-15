<?php

namespace Evrinoma\ContractBundle\Tests\Functional\Controller;


use Evrinoma\ContractBundle\Fixtures\FixtureInterface;
use Evrinoma\TestUtilsBundle\Action\ActionTestInterface;
use Evrinoma\TestUtilsBundle\Functional\AbstractFunctionalTest;
use Psr\Container\ContainerInterface;

/**
 * @group functional
 */
final class HierarchyApiControllerTest extends AbstractFunctionalTest
{
//region SECTION: Fields
    protected string $actionServiceName = 'evrinoma.contract.hierarchy.test.functional.action.hierarchy';
//endregion Fields

//region SECTION: Protected
    protected function getActionService(ContainerInterface $container): ActionTestInterface
    {
        return $container->get($this->actionServiceName);
    }
//endregion Protected

//region SECTION: Getters/Setters
    public static function getFixtures(): array
    {
        return [FixtureInterface::HIERARCHY_FIXTURES];
    }
//endregion Getters/Setters
}