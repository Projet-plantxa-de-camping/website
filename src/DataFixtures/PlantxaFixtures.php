<?php

namespace App\DataFixtures;

use App\Entity\Plantxa;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PlantxaFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $roles = array(
            array("name" => 1),
            array("name" => 2),
            array("name" => 3)
        );

        foreach ($roles as $item) {
            $plantxa = new Plantxa();
            $plantxa->setName($item["name"]);
            $manager->persist($plantxa);
        }
        $manager->flush();
    }
}
