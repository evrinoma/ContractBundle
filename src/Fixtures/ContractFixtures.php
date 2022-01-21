<?php

namespace Evrinoma\ContractBundle\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Evrinoma\ContractBundle\Entity\Contract\BaseContract;
use Evrinoma\ContractBundle\Entity\Define\BaseHierarchy;
use Evrinoma\ContractBundle\Entity\Define\BaseType;

final class ContractFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
//region SECTION: Fields
    private array $data = [
        ['active' => 'a', 'created_at' => '2006-10-23 10:21:50', 'updated_at' => '2013-10-23 10:21:50',],
        ['active' => 'a', 'created_at' => '2007-10-23 10:21:50', 'updated_at' => '2014-10-23 10:21:50',],
        ['active' => 'a', 'created_at' => '2008-10-23 10:21:50', 'updated_at' => '2015-10-23 10:21:50',],
        ['active' => 'b', 'created_at' => '2009-10-23 10:21:50', 'updated_at' => '2016-10-23 10:21:50',],
        ['active' => 'b', 'created_at' => '2010-10-23 10:21:50', 'updated_at' => '2017-10-23 10:21:50',],
        ['active' => 'd', 'created_at' => '2011-10-23 10:21:50', 'updated_at' => '2018-10-23 10:21:50',],
        ['active' => 'd', 'created_at' => '2012-10-23 10:21:50', 'updated_at' => '2019-10-23 10:21:50',],
        ['active' => 'a', 'created_at' => '2013-10-23 10:21:50',],
        ['active' => 'a', 'created_at' => '2014-10-23 10:21:50',],
        ['active' => 'a', 'created_at' => '2015-10-23 10:21:50',],
        ['active' => 'b', 'created_at' => '2016-10-23 10:21:50',],
        ['active' => 'b', 'created_at' => '2017-10-23 10:21:50',],
        ['active' => 'd', 'created_at' => '2018-10-23 10:21:50',],
        ['active' => 'd', 'created_at' => '2019-10-23 10:21:50',],
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
        $short          = self::getReferenceName();
        $shortType      = TypeFixtures::getReferenceName();
        $shortHierarchy = HierarchyFixtures::getReferenceName();

        $i = 0;
        foreach ($this->referenceRepository->getReferences() as $keyType => $type) {
            if (!str_contains($keyType, $shortType)) {
                continue;
            }
            foreach ($this->referenceRepository->getReferences() as $keyHierarchy => $hierarchy) {
                if (!str_contains($keyHierarchy, $shortHierarchy)) {
                    continue;
                }
                foreach ($this->data as $record) {
                    $entity = new BaseContract();
                    $entity->setActive($record['active']);
                    $entity->setCreatedAt(new \DateTimeImmutable($record['created_at']));
                    if (isset($record['updated_at'])) {
                        $entity->setUpdatedAt(new \DateTimeImmutable($record['updated_at']));
                    }
                    $reference = $manager->getReference(BaseType::class, $type->getId());
                    $entity->setType($reference);
                    $reference = $manager->getReference(BaseHierarchy::class, $hierarchy->getId());
                    $entity->setHierarchy($reference);
                    $manager->persist($entity);
                    $this->addReference($short.$i, $entity);
                    $i++;
                }
            }
        }

        return $this;
    }

    public static function getReferenceName(): string
    {
        return (new \ReflectionClass(BaseContract::class))->getShortName()."_";
    }
//endregion Private

//region SECTION: Getters/Setters
    public static function getGroups(): array
    {
        return [
            FixtureInterface::CONTRACT_FIXTURES,
        ];
    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [TypeFixtures::class, HierarchyFixtures::class];
    }
}