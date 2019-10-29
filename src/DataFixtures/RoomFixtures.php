<?php

namespace App\DataFixtures;

use App\Entity\Room;
use App\DataFixtures\ApartmentFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class RoomFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $recordings = 8;

        for ($y = 0; $y < $recordings; $y++) {
            $apartment = new Room();
            $apartment->setName(array('Eden', 'Earl', 'Montana', 'Madrona', 'Steward', 'MyRoom', 'Lewis', 'CIA')[$y]);
            $apartment->setApartment($this->getDependencies()[rand(0, count($this->getDependencies() - 1))]);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            ApartmentFixtures::class
        );
    }
}
