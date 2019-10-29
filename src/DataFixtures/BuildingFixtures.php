<?php

namespace App\DataFixtures;

use App\Entity\Building;
use App\DataFixtures\AppFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class BuildingFixtures extends AppFixtures
{
    public const BUILDING_REFERENCE = 'building';
    
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        parent::load($manager);

        $this->createMany(Building::class, 10, function(Building $building, int $count) use ($manager) {
            $building->setName($this->faker->streetName);
        });

        $manager->flush();
    }
}
