<?php

namespace App\Controller;

use App\Entity\Chambre;
use App\Form\ChambreType;
use App\Entity\Session;
use App\Form\SessionType;
use App\LoggerPatientOS;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChambreController extends AbstractController
{
    /**
     * @Route("/creerChambre", name="creerChambre")
     */
    public function creerChambre(Request $request): Response
    {
        $chambre = new Chambre();
        $form = $this->createForm(ChambreType::class,$chambre);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($chambre);
            $entityManager->flush();
            $logger = new LoggerPatientOS();
            $logger->ajoutLogInfo($this->getUser()->getUsername(). " a créé la chambre : " . $chambre->getService()->getNomService() . " - " . $chambre->getId());
        }

        return $this->render('chambre/formulaire.html.twig', [
            'formChambre' => $form->createView()
        ]);
    }
    /**
     * @Route("/voirChambre", name="voirChambre")
     */
    public function voirChambre(): Response
    {
        if(empty($_POST['Service']) && empty($_POST['NombreLit'])){
            $chambres = $this->getDoctrine()
                ->getManager()
                ->getRepository(Chambre::class)
                ->findAll();
        }else{
            $chambres = $this->getDoctrine()
                ->getManager()
                ->getRepository(Chambre::class)
                ->search($_POST['Service'],$_POST['NombreLit']);
        }


        return $this->render('chambre/voirChambre.html.twig', [
            'chambres' => $chambres
        ]);

    }
    /**
     * @Route("/voirChambre/{id}", name="modifierChambre")
     */
    public function modifierChambre(int $id,Request $request): Response
    {
        $chambre = $this->getDoctrine()
            ->getManager()
            ->getRepository(Chambre::class)
            ->findBy([
                'id' => $id
            ]);
        $form = $this ->createForm(ChambreType::class,$chambre[0]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $chambre = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($chambre);
            $entityManager->flush();
            $logger = new LoggerPatientOS();
            $logger->ajoutLogInfo($this->getUser()->getUsername(). " a modifié la chambre : " . $chambre->getService()->getNomService() . " - " . $chambre->getId());
        }
        return $this->render('chambre/modifierChambre.html.twig', [
            'chambres' => $chambre,
            'formChambre' => $form->createView()
        ]);
    }


}
