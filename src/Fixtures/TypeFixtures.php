<?php

namespace Evrinoma\ContractBundle\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Evrinoma\ContractBundle\Entity\Define\BaseType;
use Evrinoma\ContractBundle\Fixtures\Payload\Type;

final class TypeFixtures extends Fixture implements FixtureGroupInterface
{
//region SECTION: Fields
    private static array $data = [
        ['identity' => 'main_income'],
        ['identity' => 'sub_expenses'],
        ['identity' => 'other',],
        ['identity' => 'pdf'],
        ['identity' => 'gost'],
        ['identity' => 'sys'],
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
            $entity = new BaseType();
            $entity->setIdentity($record['identity']);
            $manager->persist($entity);
            $this->addReference($short.$i, $entity);
            $i++;
        }

        return $this;
    }

    public static function getReferenceName(): string
    {
        return (new \ReflectionClass(BaseType::class))->getShortName();
    }
//endregion Private

//region SECTION: Getters/Setters
    public static function getGroups(): array
    {
        return [
            FixtureInterface::TYPE_FIXTURES,
            FixtureInterface::CONTRACT_FIXTURES,
        ];
    }
}