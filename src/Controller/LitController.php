<?php

namespace App\Controller;

use App\Entity\Chambre;
use App\Entity\Lit;
use App\Form\LitType;
use App\LoggerPatientOS;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LitController extends AbstractController
{
    /**
     * @Route("/creerLit", name="creerLit")
     */
    public function creerLit(Request $request): Response
    {
        $lit= new Lit();
        $form = $this->createForm(LitType::class,$lit);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($lit);
            $entityManager->flush();
            $logger = new LoggerPatientOS();
            $logger->ajoutLogInfo($this->getUser()->getUsername(). " a crée le lit : " . $lit->getChambre()->getService()->getNomService() . " - " . $lit->getId());
        }

        return $this->render('lit/formulaire.html.twig', [
            'formLit' => $form->createView()
        ]);
    }

    /**
     * @Route("/voirLit", name="voirLit")
     */
    public function voirLit(): Response
    {

        if(empty($_POST['Service']) && empty($_POST['id'])){
            $lits = $this->getDoctrine()
                ->getManager()
                ->getRepository(Lit::class)
                ->findAll();
        }else{
            $lits = $this->getDoctrine()
                ->getManager()
                ->getRepository(Lit::class)
                ->search($_POST['Service'],$_POST['Chambre']);
        }
        return $this->render('lit/voirLit.html.twig', [
            'lits' => $lits,

        ]);
    }

    /**
     * @Route("/voirLit/{id}", name="modifierLit")
     */
    public function modifierLit(int $id,Request $request): Response
    {
        $lit = $this->getDoctrine()
            ->getManager()
            ->getRepository(Lit::class)
            ->find($id);


        $form = $this ->createForm(LitType::class,$lit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($lit);
            $entityManager->flush();
            $logger = new LoggerPatientOS();
            $logger->ajoutLogInfo($this->getUser()->getUsername(). " a modifié le lit : " . $lit->getChambre()->getService()->getNomService() . " - " . $lit->getId());
        }
        return $this->render('lit/modifierLit.html.twig', [
            'lits' => $lit,

            'formLit' => $form->createView()
        ]);
    }

}
