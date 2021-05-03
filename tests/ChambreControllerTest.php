<?php

namespace App\Tests;

use App\Repository\ChambreRepository;
use App\Repository\UtilisateurRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ChambreControllerTest extends WebTestCase
{
    public function testShowCreerChambreAdmin()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UtilisateurRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('admin@epsi.fr');

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $client->request('GET','/creerChambre');

        $this->assertEquals(403,$client->getResponse()->getStatusCode());
    }



    public function testShowCreerChambreSuperAdmin()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UtilisateurRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('superadmin@epsi.fr');

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $client->request('GET','/creerChambre');

        $this->assertEquals(200,$client->getResponse()->getStatusCode());
    }


    public function testShowCreerChambreSoignant()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UtilisateurRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('soignant@epsi.fr');

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $client->request('GET','/creerChambre');

        $this->assertEquals(403,$client->getResponse()->getStatusCode());
    }


    public function testShowVoirChambreAdmin()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UtilisateurRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('admin@epsi.fr');

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $client->request('GET','/voirChambre');

        $this->assertEquals(200,$client->getResponse()->getStatusCode());
    }



    public function testShowVoirChambreSuperAdmin()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UtilisateurRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('superadmin@epsi.fr');

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $client->request('GET','/voirChambre');

        $this->assertEquals(200,$client->getResponse()->getStatusCode());
    }


    public function testShowVoirChambreSoignant()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UtilisateurRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('soignant@epsi.fr');

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $client->request('GET','/voirChambre');

        $this->assertEquals(200,$client->getResponse()->getStatusCode());
    }

    public function testShowModifierChambreAdmin()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UtilisateurRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('admin@epsi.fr');

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $client->request('GET','/voirChambre/336');

        $this->assertEquals(200,$client->getResponse()->getStatusCode());
    }



    public function testShowModifierChambreSuperAdmin()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UtilisateurRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('superadmin@epsi.fr');

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $client->request('GET','/voirChambre/336');

        $this->assertEquals(200,$client->getResponse()->getStatusCode());
    }


    public function testShowModifierChambreSoignant()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UtilisateurRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('soignant@epsi.fr');

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $client->request('GET','/voirChambre/336');

        $this->assertEquals(200,$client->getResponse()->getStatusCode());
    }


    public function testEntityChambre(){
        self::bootKernel();
        $nbChambre = self::$container->get(ChambreRepository::class)->count([]);
        $this->assertEquals("100", $nbChambre);
    }

    //TODO FAIRE les test des formulaires de recherche, d'ajout et de modification et pareil pour Lit, Utilisateur, Patient etc...
}
