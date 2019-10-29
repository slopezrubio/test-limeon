<?php

namespace App\DataFixtures;

use App\DataFixtures;
use Faker\Factory;
use Faker\Generator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

abstract class AppFixtures extends Fixture
{
    /** @var Generator */
    protected $faker;
    protected $manager;

    protected function createMany(string $className, int $count, callable $factory)
    {
        for ($i = 0; $i < $count; $i++) {
            // Creates an object by using the given class name
            $entity = new $className();

            /*
             * Calls the anonymous function that sets the fake data into
             * the object properties.
             */
            $factory($entity, $i);

            /*
             * Poplulates the class created before with the properties already
             * set with fake data.
             */
            $this->manager->persist($entity);
            
            $fixtureClass = 'App\\DataFixtures\\';
            
            $fixtureClass .= explode('\\', $className)[count(explode('\\', $className)) - 1] . 'Fixtures';

            /**
             * Creates a reference or identifier to the recent created object
             * so as to be able to relate it when using other objects which
             * depend on this one.
             */
            $this->setReference($fixtureClass::BUILDING_REFERENCE, $entity);
        }
    }

    public function load(ObjectManager $manager)
    {
        $this->faker = Factory::create();
        $this->manager = $manager;
    }

    public function getRandomReference(string $className)
    {
        if (!isset($this->referencesIndex[$className])) {
            $this->referencesIndex[$className] = [];
            foreach ($this->referenceRepository as $key => $value) {
                /*if (strpos($key, strtoupper($className) . '_REFERENCE')) {
                    $this->referencesIndex[$className][] = $key;
                }*/
                print_r($key);
            }
        }

        if (empty($this->referencesIndex[$className])) {
            throw new \Exception(sprintf('Cannot find references for class %s', $className));
        }

        $randomReferenceKey = $this->faker->randomElement($this->referencesIndex[$className]);
        return $this->getReference($className::$randomReferenceKey);
    }
}
