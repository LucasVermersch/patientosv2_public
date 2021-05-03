<?php


namespace App\Tests;


use App\Entity\Service;
use App\Entity\Utilisateur;
use App\Repository\ServiceRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\LitRepository;
use PHPUnit\Framework\TestCase;


class LoginControllerTest extends WebTestCase
{
    public function testConnection()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UtilisateurRepository::class);
        $testUser = $userRepository->findOneByEmail('admin@epsi.fr');
        $client->loginUser($testUser);
        $client->request('GET', '/administrateur');
        $this->assertEquals(200,$client->getResponse()->getStatusCode());

    }
    public function testConnectionPasDeCompte()
    {
        $client = static::createClient();
        $nvUser = new Utilisateur();
        $service = static::$container->get(ServiceRepository::class)->findOneBy(array('NomService' => 'Cardiologie'));

        $nvUser->setEmail("testconnexion@epsi.fr");
        $nvUser->setPassword("test");
        $nvUser ->setService($service);
        $client->loginUser($nvUser);
        $client->request('GET', '/administrateur');
        $this->assertEquals(500,$client->getResponse()->getStatusCode());
    }
}