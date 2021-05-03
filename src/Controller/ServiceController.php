<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use App\LoggerPatientOS;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    /**
     * @Route("/creerService", name="creerService")
     */

    public function creerService(Request $request): Response
    {
        $service = new Service();
        $form = $this->createForm(ServiceType::class,$service);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($service);
            $entityManager->flush();
            $logger = new LoggerPatientOS();
            $logger->ajoutLogInfo($this->getUser()->getUsername(). " a ajouté le service : " .$service->getNomService() );
        }

        return $this->render('service/formulaire.html.twig', [
            'formService' => $form->createView()
        ]);
    }
}
