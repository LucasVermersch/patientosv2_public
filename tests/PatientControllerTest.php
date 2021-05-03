<?php

namespace App\Tests;

use App\Repository\PatientRepository;
use App\Repository\UtilisateurRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PatientControllerTest extends WebTestCase
{
    public function testShowCreerPatientAdmin()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UtilisateurRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('admin@epsi.fr');

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $client->request('GET','/nouveauPatient');

        $this->assertEquals(200,$client->getResponse()->getStatusCode());
    }

    public function testShowCreerPatientSuperAdmin()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UtilisateurRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('superadmin@epsi.fr');

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $client->request('GET','/nouveauPatient');

        $this->assertEquals(200,$client->getResponse()->getStatusCode());
    }

    public function testShowCreerPatientSoignant()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UtilisateurRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('soignant@epsi.fr');

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $client->request('GET','/nouveauPatient');

        $this->assertEquals(403,$client->getResponse()->getStatusCode());
    }

    public function testShowVoirPatientAdmin()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UtilisateurRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('admin@epsi.fr');

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $client->request('GET','/voirPatient');

        $this->assertEquals(200,$client->getResponse()->getStatusCode());
    }

    public function testShowVoirPatientSuperAdmin()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UtilisateurRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('superadmin@epsi.fr');

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $client->request('GET','/voirPatient');

        $this->assertEquals(200,$client->getResponse()->getStatusCode());
    }

    public function testShowVoirPatientSoignant()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UtilisateurRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('soignant@epsi.fr');

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $client->request('GET','/voirPatient');

        $this->assertEquals(200,$client->getResponse()->getStatusCode());
    }

    public function testShowModifierPatientAdmin()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UtilisateurRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('admin@epsi.fr');

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $client->request('GET','/voirPatient/1363');

        $this->assertEquals(200,$client->getResponse()->getStatusCode());
    }

    public function testShowModifierPatientSuperAdmin()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UtilisateurRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('superadmin@epsi.fr');

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $client->request('GET','/voirPatient/1363');

        $this->assertEquals(200,$client->getResponse()->getStatusCode());
    }

    public function testShowModifierPatientSoignant()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UtilisateurRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('soignant@epsi.fr');

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $client->request('GET','/voirPatient/1363');

        $this->assertEquals(200,$client->getResponse()->getStatusCode());
    }



    public function testEntityPatient(){
        self::bootKernel();
        $nbPatient = self::$container->get(PatientRepository::class)->count([]);
        $this->assertEquals("100", $nbPatient);
    }


}
