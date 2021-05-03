<?php

namespace Patient\DataFixtures\ORM;

use AppBundle\Entity\Patient;
use AppBundle\Entity\Service;



use Doctrine\DataFixtures\AbstractFixture;
use Doctrine\DataFixtures\FixtureInterface;
use Doctrine\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Faker\Provider\fr_FR\PhoneNumber;
use Faker\Provider\fr_FR\Address;



class ProductFixture implements FixtureInterface

{

    public function load(ObjectManager $manager)
    {
        // initialisation de l'objet Faker
        $faker = Faker\Factory::create('fr_FR');
           // créations des patient

           $patient = [];
                  for ($k=0; $k < 50; $k++) {
                      $patient[$k] = new Patient();
                      $patient[$k]->setFirstName($faker->firstName)
                          ->setPrenom($faker->lastName)
                          ->setAge($faker->numberBetween($min = 5, $max = 90))
                          ->setSexe($faker->numberBetween($min = 0, $max = 1))
                          ->setAdresse($faker->address)
                          ->setVille($faker->departmentName)
                          ->setCodePostal($faker->departmentNumber)
                          ->setEmail($faker->mail)
                          ->setTelephone($faker->serviceNumber)
                      ;

                      $randomservice = (array) array_rand($Service, rand(1, count($Service)));

                      foreach ($randomservice as $key => $value) {
                          $Patient[$k]->addService($Service[$key]);
                      }
                      $manager->persist($Patient[$k]);
                  }

                  $manager->flush();
              }

              public function getOrder()
              {
                  return 1;
              }
              }



