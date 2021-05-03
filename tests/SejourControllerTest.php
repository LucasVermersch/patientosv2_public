<?php

namespace App\Tests;

use App\Repository\SejourRepository;
use App\Repository\UtilisateurRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SejourControllerTest extends WebTestCase
{
    public function testShowCreerSejourtAdmin()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UtilisateurRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('admin@epsi.fr');

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $client->request('GET','/sejourAjouter');

        $this->assertEquals(200,$client->getResponse()->getStatusCode());
    }

    public function testShowCreerSejourSuperAdmin()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UtilisateurRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('superadmin@epsi.fr');

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $client->request('GET','/sejourAjouter');

        $this->assertEquals(200,$client->getResponse()->getStatusCode());
    }

    public function testShowCreerSejourSoignant()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UtilisateurRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('soignant@epsi.fr');

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $client->request('GET','/sejourAjouter');

        $this->assertEquals(403,$client->getResponse()->getStatusCode());
    }




    public function testShowSejourAjouterUtilisateurAdmin()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UtilisateurRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('admin@epsi.fr');

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $client->request('GET','/sejourAjouter/1363');

        $this->assertEquals(200,$client->getResponse()->getStatusCode());
    }

    public function testShowSejourAjouterUtilisateurSuperAdmin()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UtilisateurRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('superadmin@epsi.fr');

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $client->request('GET','/sejourAjouter/1363');

        $this->assertEquals(200,$client->getResponse()->getStatusCode());
    }

    public function testShowSejourAjouterUtilisateurSoignant()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UtilisateurRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('soignant@epsi.fr');

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $client->request('GET','/sejourAjouter/1363');

        $this->assertEquals(403,$client->getResponse()->getStatusCode());
    }


    public function testEntitySejour(){
        self::bootKernel();
        $nbSejour = self::$container->get(SejourRepository::class)->count([]);
        $this->assertEquals("1", $nbSejour);
    }


}
