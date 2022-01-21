<?php

namespace Evrinoma\ContractBundle\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Evrinoma\ContractBundle\Entity\Define\BaseHierarchy;

final class HierarchyFixtures extends Fixture implements FixtureGroupInterface
{
//region SECTION: Fields
    private static array $data = [
        ['identity' => 'contract'],
        ['identity' => 'add_agr'],
        ['identity' => 'contract_other'],
        ['identity' => 'add'],
        ['identity' => 'add_other'],
        ['identity' => 'contract_sys'],
    ];
//endregion Fields

//region SECTION: Public
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->create($manager);

        $manager->flush();
    }
//endregion Public

//region SECTION: Private
    private function create(ObjectManager $manager)
    {
        $short = self::getReferenceName();
        $i     = 0;

        foreach (self::$data as $record) {
            $entity = new BaseHierarchy();
            $entity->setIdentity($record['identity']);
            $manager->persist($entity);
            $this->addReference($short.$i, $entity);
            $i++;
        }

        return $this;
    }

    public static function getReferenceName(): string
    {
        return (new \ReflectionClass(BaseHierarchy::class))->getShortName();
    }
//endregion Private

//region SECTION: Getters/Setters
    public static function getGroups(): array
    {
        return [
            FixtureInterface::HIERARCHY_FIXTURES,
            FixtureInterface::CONTRACT_FIXTURES,
        ];
    }
}