<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\CPULogs;
use DateTime;

class CPULogsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
       for ($i=0; $i < 200; $i++) { 
           $cpulog = new CPULogs(0, new DateTime("now"));
           $manager->persist($cpulog);
           $manager->flush();
           $cpulog = new CPULogs(1, new DateTime("now"));
           $manager->persist($cpulog);
           $manager->flush();
           $cpulog = new CPULogs(2, new DateTime("now"));
           $manager->persist($cpulog);
           $manager->flush();
       }

       for ($i=0; $i < 100; $i++) { 
        $cpulog = new CPULogs(0, new DateTime("2020-08-07"));
        $manager->persist($cpulog);
        $manager->flush();
        $cpulog = new CPULogs(1, new DateTime("2020-08-07"));
        $manager->persist($cpulog);
        $manager->flush();
        $cpulog = new CPULogs(2, new DateTime("2020-08-07"));
        $manager->persist($cpulog);
        $manager->flush();
       }

        
    }
}
