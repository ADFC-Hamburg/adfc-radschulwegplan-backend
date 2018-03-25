<?php
namespace AppBundle\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;

use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

use AppBundle\Entity\School;

class SchoolFixtures extends Fixture implements ORMFixtureInterface, DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $s = new School();
        $s->setName('Goethe-Schule-Harburg');
        $s->setStreet('Eißendorfer Straße 26');
        $s->setPostalCode('21073');
        $s->setPlace('Hamburg');
        $s->setWebpage('https://goethe-schule-harburg.schulhomepages.hamburg.de/');
        $user = $this->getReference('adfc-admin-user');
        $s->setCreatedNow($user);
        $manager->persist($s);
        $manager->flush();

        $this->addReference('gsh-school', $s);

        
        $s = new School();
        $s->setName('Schule-Hausbruch');
        $s->setStreet('Hausbrucher Bahnhofstr.19');
        $s->setPostalCode('21147');
        $s->setPlace('Hamburg');
        $user = $this->getReference('adfc-admin-user');
        $s->setCreatedNow($user);
        $manager->persist($s);
        $manager->flush();

        $this->addReference('hausbruch-school', $s);
    }
    
    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }
}