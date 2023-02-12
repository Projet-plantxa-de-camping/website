<?php

namespace App\DataFixtures;

use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RoleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $roles = array(
            array("label" => "ROLE_USER"),
            array("label" => "ROLE_EDITOR"),
            array("label" => "ROLE_ADMIN")
        );

        foreach ($roles as $item) {
            $role = new Role();
            $role->setLabel($item["label"] );
            $manager->persist($role);
        }

        $manager->flush();
    }
}
