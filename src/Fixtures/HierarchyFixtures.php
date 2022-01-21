<?php

namespace Evrinoma\ContractBundle\Fixtures;

use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Evrinoma\ContractBundle\Entity\Define\BaseHierarchy;
use Evrinoma\TestUtilsBundle\Fixtures\AbstractFixture;

class HierarchyFixtures extends AbstractFixture implements FixtureGroupInterface
{
//region SECTION: Fields
    protected static array $data = [
        ['identity' => 'contract'],
        ['identity' => 'add_agr'],
        ['identity' => 'contract_other'],
        ['identity' => 'add'],
        ['identity' => 'add_other'],
        ['identity' => 'contract_sys'],
    ];

    protected static string $class = BaseHierarchy::class;
//endregion Fields

//region SECTION: Private
    protected function create(ObjectManager $manager)
    {
        $short = self::getReferenceName();
        $i     = 0;

        foreach (static::$data as $record) {
            $entity = new BaseHierarchy();
            $entity->setIdentity($record['identity']);
            $manager->persist($entity);
            $this->addReference($short.$i, $entity);
            $i++;
        }

        return $this;
    }
//endregion Private

//region SECTION: Getters/Setters
    public static function getGroups(): array
    {
        return [
            FixtureInterface::HIERARCHY_FIXTURES,
            FixtureInterface::CONTRACT_FIXTURES,
            FixtureInterface::SIDE_FIXTURES,
        ];
    }
}