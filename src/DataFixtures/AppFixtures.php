<?php

namespace App\DataFixtures;

use App\Entity\UkTax;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $manager->persist((new UkTax())->setMin(0)->setMax(5_000)->setPercent(0));
        $manager->persist((new UkTax())->setMin(5_000)->setMax(20_000)->setPercent(20));
        $manager->persist((new UkTax())->setMin(20_000)->setPercent(40));

        $manager->flush();
    }
}
