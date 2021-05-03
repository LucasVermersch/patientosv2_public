<?php

namespace App\Controller;

use App\LoggerPatientOS;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            $logger = new LoggerPatientOS();
            $logger->ajoutLogInfo($this->getUser()->getUsername() . " est connecté");
            if($this->getUser()->getRoles()[0] != "ROLE_PATIENT"){
                return $this->redirectToRoute('administrateur');
            }else{
                return $this->redirectToRoute('accueil');
            }
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'navbar' => false
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {

        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
