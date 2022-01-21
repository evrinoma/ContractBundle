<?php

namespace Evrinoma\ContractBundle\Fixtures;

use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Evrinoma\CodeBundle\Fixtures\BunchFixtures;
use Evrinoma\ContractBundle\Entity\Contract\BaseContract;
use Evrinoma\ContractBundle\Entity\Side\BaseSide;
use Evrinoma\TestUtilsBundle\Fixtures\AbstractFixture;

class SideFixtures extends AbstractFixture implements FixtureGroupInterface, DependentFixtureInterface
{
//region SECTION: Fields
    protected static array $data = [
        'left'  => ['test0', 'test1', 'test2'],
        'right' => ['test3', 'test4', 'test5'],
    ];

    protected static string $class = BaseSide::class;
//endregion Fields

//region SECTION: Private
    /**
     * @param ObjectManager $manager
     *
     * @return $this
     */
    protected function create(ObjectManager $manager): self
    {
        $short         = self::getReferenceName();
        $shortContract = ContractFixtures::getReferenceName();

        $i = 0;
        foreach ($this->referenceRepository->getReferences() as $keyType => $type) {
            if (!str_contains($keyType, $shortContract)) {
                continue;
            }
            $reference = $manager->getReference(BaseContract::class, $type->getId());
            foreach (static::$data['left'] as $value) {
                $entity = new BaseSide();
                $entity->setIdentity($value);
                $entity->setLeft($reference);
                $manager->persist($entity);
                $this->addReference($short.$i, $entity);
                $i++;
            }

            foreach (static::$data['right'] as $value) {
                $entity = new BaseSide();
                $entity->setIdentity($value);
                $entity->setRight($reference);
                $manager->persist($entity);
                $this->addReference($short.$i, $entity);
                $i++;
            }
        }

        return $this;
    }
//endregion Private

//region SECTION: Getters/Setters
    public static function getGroups(): array
    {
        return [FixtureInterface::SIDE_FIXTURES,];
    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [
            TypeFixtures::class,
            HierarchyFixtures::class,
            ContractFixtures::class,
        ];
    }
}