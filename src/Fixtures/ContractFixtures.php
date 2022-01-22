<?php

namespace Evrinoma\ContractBundle\Fixtures;

use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Evrinoma\ContractBundle\Entity\Contract\BaseContract;
use Evrinoma\ContractBundle\Entity\Define\BaseHierarchy;
use Evrinoma\ContractBundle\Entity\Define\BaseType;
use Evrinoma\TestUtilsBundle\Fixtures\AbstractFixture;

class ContractFixtures extends AbstractFixture implements FixtureGroupInterface, DependentFixtureInterface
{
//region SECTION: Fields
    protected static array $data = [
        ['active' => 'a', 'created_at' => '2006-10-23 10:21:50', 'updated_at' => '2013-10-23 10:21:50', 'name' => 'name00', 'description' => 'description00', 'number' => '1',],
        ['active' => 'a', 'created_at' => '2007-10-23 10:21:50', 'updated_at' => '2014-10-23 10:21:50', 'name' => 'name01', 'description' => 'description01', 'number' => '2',],
        ['active' => 'a', 'created_at' => '2008-10-23 10:21:50', 'updated_at' => '2015-10-23 10:21:50', 'name' => 'name02', 'description' => 'description02', 'number' => '3',],
        ['active' => 'b', 'created_at' => '2009-10-23 10:21:50', 'updated_at' => '2016-10-23 10:21:50', 'name' => 'name03', 'description' => 'description03', 'number' => '4',],
        ['active' => 'b', 'created_at' => '2010-10-23 10:21:50', 'updated_at' => '2017-10-23 10:21:50', 'name' => 'name04', 'description' => 'description04', 'number' => '5',],
        ['active' => 'd', 'created_at' => '2011-10-23 10:21:50', 'updated_at' => '2018-10-23 10:21:50', 'name' => 'name05', 'description' => 'description05', 'number' => '6',],
        ['active' => 'd', 'created_at' => '2012-10-23 10:21:50', 'updated_at' => '2019-10-23 10:21:50', 'name' => 'name06', 'description' => 'description06', 'number' => '7',],
        ['active' => 'a', 'created_at' => '2013-10-23 10:21:50', 'name' => 'name07', 'description' => 'description07', 'number' => '8',],
        ['active' => 'a', 'created_at' => '2014-10-23 10:21:50', 'name' => 'name08', 'description' => 'description08', 'number' => '9',],
        ['active' => 'a', 'created_at' => '2015-10-23 10:21:50', 'name' => 'name09', 'description' => 'description09', 'number' => '10',],
        ['active' => 'b', 'created_at' => '2016-10-23 10:21:50', 'name' => 'name10', 'description' => 'description10', 'number' => '11',],
        ['active' => 'b', 'created_at' => '2017-10-23 10:21:50', 'name' => 'name11', 'description' => 'description11', 'number' => '12',],
        ['active' => 'd', 'created_at' => '2018-10-23 10:21:50', 'name' => 'name12', 'description' => 'description12', 'number' => '13',],
        ['active' => 'd', 'created_at' => '2019-10-23 10:21:50', 'name' => 'name13', 'description' => 'description13', 'number' => '14',],
    ];

    protected static string $class = BaseContract::class;
//endregion Fields

//region SECTION: Private
    /**
     * @param ObjectManager $manager
     *
     * @return $this
     * @throws \Exception
     */
    protected function create(ObjectManager $manager): self
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
                foreach (static::$data as $record) {
                    $entity = new BaseContract();
                    $entity->setActive($record['active']);
                    $entity->setCreatedAt(new \DateTimeImmutable($record['created_at']));
                    if (isset($record['updated_at'])) {
                        $entity->setUpdatedAt(new \DateTimeImmutable($record['updated_at']));
                    }
                    $entity->setName($record['name']);
                    $entity->setNumber($record['number']);
                    $entity->setDescription($record['description']);
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
//endregion Private

//region SECTION: Getters/Setters
    public static function getGroups(): array
    {
        return [
            FixtureInterface::CONTRACT_FIXTURES,
            FixtureInterface::SIDE_FIXTURES,
        ];
    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [
            TypeFixtures::class,
            HierarchyFixtures::class,
        ];
    }
}