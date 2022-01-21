<?php

namespace Evrinoma\ContractBundle\Fixtures;

use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Evrinoma\CodeBundle\Fixtures\BunchFixtures;
use Evrinoma\ContractBundle\Entity\Define\BaseType;
use Evrinoma\TestUtilsBundle\Fixtures\AbstractFixture;

final class TypeFixtures extends AbstractFixture implements FixtureGroupInterface
{
//region SECTION: Fields
    protected static array $data = [
        ['identity' => 'main_income'],
        ['identity' => 'sub_expenses'],
        ['identity' => 'other',],
        ['identity' => 'pdf'],
        ['identity' => 'gost'],
        ['identity' => 'sys'],
    ];

    protected static string $class = BaseType::class;
//endregion Fields

//region SECTION: Private
    /**
     * @param ObjectManager $manager
     *
     * @return $this
     */
    protected function create(ObjectManager $manager): self
    {
        $short = self::getReferenceName();
        $i     = 0;

        foreach (self::$data as $record) {
            $entity = new BaseType();
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
            FixtureInterface::TYPE_FIXTURES,
            FixtureInterface::CONTRACT_FIXTURES,
            FixtureInterface::SIDE_FIXTURES,
        ];
    }
}