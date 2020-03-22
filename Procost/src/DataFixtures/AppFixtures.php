<?php

namespace App\DataFixtures;

use App\Entity\Compte;
use App\Entity\Employer;
use App\Entity\Metier;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    /** @var ObjectManager */
    private $manager;

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->loadMetier();
        $this->loadEmployer();


        $this->manager->flush();
    }
    private function loadMetier(): void
    {
        for ($i = 0; $i < 14; $i++) {

            $emp = (new Metier())
                ->setMetierTitre('metiertest - '.$i)
                ->setDescription("test - ".$i)

            ;



            $this->manager->persist($emp);
            $this->addReference('image'.$i, $emp);
        }
    }
    private function loadEmployer(): void
    {
        for ($i = 0; $i < 14; $i++) {


            $emp = (new Employer())
                ->setPrenom('jerome - '.$i)
                ->setNom('Boris -' .$i)
                ->setEmail('jerome.boris@gmail.com')
                ->setMetier($this->getReference('metier'.$i))
                ->setCout(10)
                ->setDateEmbauche(new \DateTime());


            $this->manager->persist($emp);
            $this->addReference('image'.$i, $emp);
        }
    }


}
