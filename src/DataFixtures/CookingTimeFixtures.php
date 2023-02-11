<?php

namespace App\DataFixtures;

use App\Entity\CookingTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CookingTimeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $array = array(
            array("name" => "15 minutes", "price" => 10, "discount" => 5),
            array("name" => "30 minutes", "price" => 20, "discount" => 10),
            array("name" => "1 heure", "price" => 20, "discount" => 10)
        );
        foreach ($array as $item) {
            $time = new CookingTime();
            $time->setName($item["name"] );
            $time->setPrice($item["price"]);
            $time->setDiscount($item["discount"]);
            $manager->persist($time);
        }

        $manager->flush();
    }
}