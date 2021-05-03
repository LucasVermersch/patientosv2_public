<?php

namespace App\DataFixtures;

use App\Entity\Sejour;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Patient;
use App\Entity\Service;
use App\Entity\Chambre;
use App\Entity\Lit;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $patient = new Patient();
        $service = new Service();
        $chambre = new Chambre();
        $lit = new Chambre();
        $faker = Faker\Factory::create('fr_FR');

        $tableau = ["Cardiologie", "Neurologie", "Traumatologie", "Orthopédie", "Urologie", "Pneumologie"];

        $service = [];
        for ($a = 0; $a < (count($tableau)); $a++) {
            $id = $tableau[$a];

            $service[$a] = new Service();
            $service[$a]->setNomService($id);
            $manager->persist($service[$a]);
        }


        $patient = [];
        for ($i = 0; $i < 100; $i++) {
            $patient[$i] = new Patient();
            $patient[$i]->setNom($faker->firstName)
                ->setPrenom($faker->lastName)
                ->setAge($faker->numberBetween($min = 5, $max = 90))
                ->setSexe($faker->numberBetween($min = 0, $max = 1))
                ->setAdresse($faker->address)
                ->setVille($faker->city)
                ->setCodePostal($faker->randomNumber($nbDigits = 5, $strict = false))
                ->setEmail($faker->email)
                ->setTelephone($faker->randomNumber($nbDigits = 9, $strict = false))
                ->setService($service[$i % 6]);
            $manager->persist($patient[$i]);
        }
        $chambre = [];
        for ($c = 0; $c < 100; $c++) {
            $chambre[$c] = new Chambre();
            $chambre[$c]->setNombreLit($faker->numberBetween($min = 1, $max = 3))
                ->setService($service[$c % 6]);
            $manager->persist($chambre[$c]);
        }
        $lit = [];
        $etatlit = ["bon", "mauvais", "trés mauvais", "trés bon","correct"];
        for ($l = 0; $l < 200; $l++) {
            $lit[$l] = new Lit();
            $etat = rand(0,count($etatlit)-1);
            $ida = $etatlit[$etat];
            $lit[$l]->setEtatDuLit($ida)
                ->setChambre($chambre[$l % 99])
                ->setOccupation($faker->randomElement($array = array (FALSE)));
            $manager->persist($lit[$l]);
        }

        $manager->flush();
    }


}
