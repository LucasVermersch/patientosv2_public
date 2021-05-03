<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Repository\CalendarRepository;
use App\Repository\RendezVousRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CalController extends AbstractController
{
    /**
     * @Route("/cal/{id}", name="cal")
     */
    public function index(RendezVousRepository $rendezVous,int $id): Response
    {
        $medecin = $this->getDoctrine()->getRepository(Utilisateur::class)->findOneBy(array('id'=>$id));
        $events = $rendezVous->findBy(array("utilisateur"=>$medecin));
        $rdvs = [];
        foreach ($events as $event){

            $rdvs[] = [
                'id' => $event->getId(),
                'start' => $event->getStart()->format('Y-m-d H:i:s'),
                'end' => $event->getEnd()->format('Y-m-d H:i:s'),
                'title' => "Rendez vous avec". $event->getPatient()->getNom(). " " . $event->getPatient()->getPrenom(),
                'description' => $event->getDescription(),
                'backgroundColor' => $event->getBackgroundColor(),
                'borderColor' => $event->getBorderColor(),
                'textColor' => $event->getTextColor(),
                'allDay' => $event->getAllDay(),
                'patient' => $event->getPatient(),
                'utilisateur' => $event->getUtilisateur()
            ];
        }

        $data = json_encode($rdvs);

        return $this->render('cal/index.html.twig', compact('data'));
    }
}
