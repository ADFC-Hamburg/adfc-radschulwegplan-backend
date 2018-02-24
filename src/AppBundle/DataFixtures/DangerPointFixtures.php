<?php
namespace AppBundle\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;

use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\DangerPoint;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class DangerPointFixtures  extends Fixture implements ORMFixtureInterface, DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // create 20 DangerPoints
        for ($i = 0; $i < 20; $i++) {
            $pt = new DangerPoint();
            $pt->setTitle('point '.$i);
            $pt->setDescription('point desc '.$i);
            $pt->setTypeId($i);
            $lat=53.5+(mt_rand(0, 1000)/100);
            $lon=10+(mt_rand(0, 100)/100);
            $pt->setPos(sprintf('SRID=4326;POINT(%f %f)',$lat, $lon));
            $user = $this->getReference('student-user');
            $pt->setCreatedNow($user);
            $manager->persist($pt);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }
}
