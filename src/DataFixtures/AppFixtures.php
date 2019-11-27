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
    private $referencesIndex = [];

    /*
     * Creates as many fake entries into the Entity of the first argument as specified in
     * $count. The callable usually provides the fields or columns where to inject the data.
     */
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

            /**
             * Creates a reference or identifier to the recent created object
             * so as to be able to relate it when using other objects which
             * depend on this one.
             */
            $this->addReference($className . '_' . $i, $entity);
        }
    }

    /**
     * Loads the factory and the ObjectManager objects.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->faker = Factory::create();
        $this->manager = $manager;
    }

    /**
     * Gives a random reference belonging to the class passed as first argument.
     *
     * @param string $className
     * @return object
     * @throws \Exception
     */
    public function getRandomReference(string $className)
    {
        // Checks if there already are reference belonging to the given class.
        if (!isset($this->referencesIndex[$className])) {

            // Creates an array where the references of the class are going to be stored.
            $this->referencesIndex[$className] = [];

            /*
             * Loops through the references gathered during loading the fixtures and saves those
             * belonging to the given class.
             */
            foreach ($this->referenceRepository->getReferences() as $key => $value) {
                if (strpos($key, $className . '_') === 0) {
                    $this->referencesIndex[$className][] = $key;
                }
            }
        }

        // If no reference has been found.
        if (empty($this->referencesIndex[$className])) {
            throw new \Exception(sprintf('Cannot find references for class %s', $className));
        }

        /**
         * Choose randomly on of the references collected before.
         */
        $randomReferenceKey = $this->faker->randomElement($this->referencesIndex[$className]);
        return $this->getReference($randomReferenceKey);
    }
}
