<?php

namespace App\Controller;

use App\Entity\Lit;
use App\Entity\Sejour;
use App\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/administrateur", name="administrateur")
     */
    public function index(): Response
    {
        $medecin = $this->getDoctrine()->getRepository(Utilisateur ::class)->findOneBy(array('email'=>$this->getUser()->getUsername()));
        $nbOcupee = $this->getDoctrine()->getManager()->getRepository(Sejour::class)->chercherLitOccupee();
        $nbOcupeeDemain = $this->getDoctrine()->getManager()->getRepository(Sejour::class)->chercherLitOccupeeDemain();
        $nbLit = $this->getDoctrine()->getManager()->getRepository(Lit::class)->compterLit();
        $tableauJour=[];
        for($i = 0; $i<7 ;$i++){
            $jour =$this->getDoctrine()->getManager()->getRepository(Sejour::class)->chercherLitOccupeeJourMoins($i+1);
            $tableauJour[$i] = $jour[0][1];
        }
        $tableauJours=[];
        for($c = 0; $c<7 ;$c++) {
            $jours = $this->getDoctrine()->getManager()->getRepository(Sejour::class)->chercherLitOccupeeJourPlus($c + 1);
            $tableauJours[$c] = $jours[0][1];
        }
        $nbDisponibleDemain = $nbLit[0][1]-$nbOcupeeDemain[0][1];
        $taux = ($nbOcupee[0][1]/$nbLit[0][1])*100;
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'navbar' => true,
            'taux'=>$taux,
            'nbDispoDemain' => $nbDisponibleDemain,
            'tabJour'  => $tableauJour,
            'nbDemain' => $nbOcupeeDemain[0][1],
            'nbOccupee' => $nbOcupee[0][1],
            'tabJours'  => $tableauJours,
            'medecin' => $medecin
        ]);
    }
}
