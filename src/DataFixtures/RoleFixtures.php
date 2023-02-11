<?php

namespace App\DataFixtures;

use App\Entity\CookingTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RoleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $roles = array(
            array("label" => "User"),
            array("label" => "Admin")
        );
        foreach ($roles as $item) {
            $role = new CookingTime();
            $role->setLabel($item["label"] );
            $manager->persist($role);
        }

        $manager->flush();
    }
}