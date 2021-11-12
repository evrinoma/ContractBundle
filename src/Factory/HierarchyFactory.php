<?php
namespace Evrinoma\ContractBundle\Factory;

use Evrinoma\ContractBundle\Dto\HierarchyApiDtoInterface;
use Evrinoma\ContractBundle\Entity\Define\BaseHierarchy;
use Evrinoma\ContractBundle\Model\Define\HierarchyInterface;

final class HierarchyFactory implements HierarchyFactoryInterface
{
    private static string $entityClass = BaseHierarchy::class;

    public function create(HierarchyApiDtoInterface $dto): HierarchyInterface
    {
        /** @var BaseHierarchy $owner */
        $owner = new self::$entityClass;

        $owner
            ->setIdentity($dto->getIdentity());

        return $owner;
    }
}