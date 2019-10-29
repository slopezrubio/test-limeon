<?php

namespace App\DataFixtures;

use App\Entity\Room;
use App\Entity\Apartment;
use App\DataFixtures\AppFixtures;
use App\DataFixtures\ApartmentFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class RoomFixtures extends AppFixtures implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        parent::load($manager);

        $this->createMany(Room::class, 17, function(Room $room, int $count) use ($manager) {
            $room->setName($this->faker->secondaryAddress);
            $room->setApartment($this->getRandomReference(Apartment::class));
        });

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            ApartmentFixtures::class
        );
    }
}
