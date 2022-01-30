<?php

namespace Evrinoma\ContractBundle\Factory;

use Evrinoma\ContractBundle\Dto\HierarchyApiDtoInterface;
use Evrinoma\ContractBundle\Entity\Define\BaseHierarchy;
use Evrinoma\ContractBundle\Model\Define\HierarchyInterface;

final class HierarchyFactory implements HierarchyFactoryInterface
{
//region SECTION: Fields
    private static string $entityClass = BaseHierarchy::class;
//endregion Fields

//region SECTION: Public
    public function create(HierarchyApiDtoInterface $dto): HierarchyInterface
    {
        /** @var BaseHierarchy $hierarchy */
        $hierarchy = new self::$entityClass;

        $hierarchy->setIdentity(trim($dto->getIdentity()));

        return $hierarchy;
    }
//endregion Public
}