<?php


namespace App\Tests;

use App\Repository\LitRepository;
use App\Repository\UtilisateurRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LitControllerTest extends WebTestCase
{
    public function testShowCreerLitAdmin()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UtilisateurRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('admin@epsi.fr');

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $client->request('GET','/creerLit');

        $this->assertEquals(403,$client->getResponse()->getStatusCode());
    }

    public function testShowCreerLitSuperAdmin()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UtilisateurRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('superadmin@epsi.fr');

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $client->request('GET','/creerLit');

        $this->assertEquals(200,$client->getResponse()->getStatusCode());
    }

    public function testShowCreerLitSoignant()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UtilisateurRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('soignant@epsi.fr');

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $client->request('GET','/creerLit');

        $this->assertEquals(403,$client->getResponse()->getStatusCode());
    }

    public function testShowVoirLitAdmin()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UtilisateurRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('admin@epsi.fr');

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $client->request('GET','/voirLit');

        $this->assertEquals(200,$client->getResponse()->getStatusCode());
    }

    public function testShowVoirLitSuperAdmin()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UtilisateurRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('superadmin@epsi.fr');

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $client->request('GET','/voirLit');

        $this->assertEquals(200,$client->getResponse()->getStatusCode());
    }

    public function testShowVoirLitSoignant()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UtilisateurRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('soignant@epsi.fr');

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $client->request('GET','/voirLit');

        $this->assertEquals(200,$client->getResponse()->getStatusCode());
    }

    public function testShowModifierLitAdmin()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UtilisateurRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('admin@epsi.fr');

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $client->request('GET','/voirLit/817');

        $this->assertEquals(200,$client->getResponse()->getStatusCode());
    }

    public function testShowModifierLitSuperAdmin()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UtilisateurRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('superadmin@epsi.fr');

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $client->request('GET','/voirLit/817');

        $this->assertEquals(200,$client->getResponse()->getStatusCode());
    }

    public function testShowModifierLitSoignant()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UtilisateurRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('soignant@epsi.fr');

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $client->request('GET','/voirLit/817');

        $this->assertEquals(200,$client->getResponse()->getStatusCode());
    }


    public function testEntityLit()
    {
        self::bootKernel();
        $nbLit = self::$container->get(LitRepository::class)->count([]);
        $this->assertEquals("200", $nbLit);
    }

}
