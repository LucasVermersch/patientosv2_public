<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Entity\RendezVous;
use App\Entity\Service;
use App\Entity\Utilisateur;
use App\Repository\RendezVousRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/accueil", name="accueil")
     */
    public function index(): Response
    {
        $user = $this->getDoctrine()->getRepository(Patient::class)->findOneBy(array('email'=>$this->getUser()->getUsername()));
        $rdv = $this->getDoctrine()->getRepository(RendezVous::class)->findBy(array('patient'=> $user));

        return $this->render('accueil/index.html.twig', [
            'utilisateur' => $user,
            'rdvs' => $rdv
        ]);
    }

    /**
     * @Route("/accueil/rdv", name="rdv")
     */
    public function rdv(): Response
    {
        $user = $this->getDoctrine()->getRepository(Patient::class)->findOneBy(array('email'=>$this->getUser()->getUsername()));
        return $this->render('accueil/rdv.html.twig',[
            'utilisateur' => $user
        ]);
    }

    /**
     * @Route("/accueil/rdv/{id}", name="rdvRecherche")
     */
    public function rdvSpeSearch(string $id): Response
    {
        $user = $this->getDoctrine()->getRepository(Patient::class)->findOneBy(array('email'=>$this->getUser()->getUsername()));
        $service = $this->getDoctrine()->getRepository(Service::class)->findOneBy(array('NomService'=>$id));

        if(isset($_POST['nom']) && $_POST['nom'] != ""){
            $medecin = $this->getDoctrine()->getRepository(Utilisateur::class)->rechercheNom($_POST['nom'],$service);
        }else{
            $medecin = $this->getDoctrine()->getRepository(Utilisateur::class)->findBy(array('Service'=>$service));
        }

        return $this->render('accueil/rdvSearch.html.twig',[
            'utilisateur' => $user,
            'medecins' => $medecin

        ]);

    }
    /**
     * @Route("/accueil/priserdv/{id}", name="priserdv")
     */
    public function priseRdv(int $id): Response
    {
        $user = $this->getDoctrine()->getRepository(Patient::class)->findOneBy(array('email'=>$this->getUser()->getUsername()));
        $medecin = $this->getDoctrine()->getRepository(Utilisateur::class)->find($id);
        $deja  = 0;
        $rdvExist = null;
        if(isset($_POST['typeRdv']) && $_POST['time']){
            $dateTime = strtotime($_POST['typeRdv']);
            $heure1 = $_POST['typeRdv'];
            $heure2 = $_POST['time'];
            $heure_end = strtotime($heure2)+(-strtotime($heure1));
            $rdvExist = $this->getDoctrine()->getRepository(RendezVous::class)->findRdvByDate($heure2,date('Y-m-d H:i:s',$heure_end),$id);
            if($rdvExist == null){
                $rdv = new RendezVous();
                $rdv->setUtilisateur($medecin);
                $rdv->setPatient($user);
                $rdv->setAllDay(0);
                $rdv->setBackgroundColor("#FFFFFF");
                $rdv->setTextColor("#000000");
                $rdv->setBorderColor("#FFFFFF");
                $rdv->setDescription("Rendez vous avec Dr". $user->getNom());
                $rdv->setTitle("Rendez vous avec Dr". $user->getNom());
                $rdv->setStatus(0);
                $rdv->setEnd(new \DateTime('@'.$heure_end+3600));
                $rdv->setStart(new \DateTime('@'.strtotime($heure2)+3600));
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($rdv);
                $entityManager->flush();

            }else{
                $deja = 1;
            }


        }

        return $this->render('accueil/priseRdv.html.twig',[
            'utilisateur' => $user,
            'medecin' => $medecin,
            'deja' => $deja,
            'rdv' => $rdvExist
        ]);
    }

    /**
     * @Route("/accueil/info/{id}", name="infordv")
     */
    public function infoRdv(int $id): Response
    {
        $user = $this->getDoctrine()->getRepository(Patient::class)->findOneBy(array('email'=>$this->getUser()->getUsername()));
        $rdv = $this->getDoctrine()->getRepository(RendezVous::class)->findOneBy(array('id'=>$id));


        return $this->render('accueil/infoRdv.html.twig',[
            'utilisateur' => $user,
            'rdv' =>$rdv
        ]);
    }

    /**
     * @Route("accueil/removeRdv/{id}", name="removerdv")
     */
    public function removeRdv(int $id){
        $user = $this->getDoctrine()->getRepository(Patient::class)->findOneBy(array('email'=>$this->getUser()->getUsername()));
        $rdv = $this->getDoctrine()->getRepository(RendezVous::class)->findOneBy(array('id'=>$id));
        if($rdv->getPatient()->getId() == $user->getId()){
            $supp =1;
            $rdv->setStatus(1);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
        }

        return $this->render('accueil/_removeRdv.html.twig',[
            'utilisateur' => $user,
            'rdv' =>$rdv,
            'supp' => $supp
        ]);
    }


}
