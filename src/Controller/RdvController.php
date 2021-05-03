<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Entity\RendezVous;
use App\Entity\Service;
use App\Entity\Utilisateur;
use App\Form\HorraireType;
use Symfony\Component\HttpFoundation\Request;
use Monolog\Handler\Curl\Util;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RdvController extends AbstractController
{
    /**
     * @Route("/rdv/list", name="listeRdv")
     */
    public function listRdv(): Response
    {
        $user = $this->getDoctrine()->getRepository(Utilisateur::class)->findOneBy(array('email'=>$this->getUser()->getUsername()));

        if(isset($_POST['nom']) && $_POST['nom'] != ""){
            $medecin = $this->getDoctrine()->getRepository(Utilisateur::class)->findBy(array("nom"=>$_POST['nom']));
        }else{
            $medecin = $this->getDoctrine()->getRepository(Utilisateur::class)->findAll();
        }

        return $this->render('rdv/index.html.twig',[
            'utilisateur' => $user,
            'medecins' => $medecin
        ]);
    }

    /**
     * @Route("/rdv/list/{id}", name="listeRdvId")
     */
    public function listRdvId(int $id): Response
    {
        $user = $this->getDoctrine()->getRepository(Utilisateur::class)->findOneBy(array('email'=>$this->getUser()->getUsername()));
        $medecin = $this->getDoctrine()->getRepository(Utilisateur::class)->findOneBy(array('id'=>$id));
        $rdvs = $this->getDoctrine()->getRepository(RendezVous::class)->findBy(array('utilisateur'=>$medecin));

        return $this->render('rdv/listeRdv.html.twig',[
            'utilisateur' => $user,
            'rdvs'=>$rdvs

        ]);
    }

    /**
     * @Route("/rdv/admin/{id}", name="adminRdv")
     */
    public function adminRdv(int $id){
        $user = $this->getDoctrine()->getRepository(Utilisateur::class)->findOneBy(array('email'=>$this->getUser()->getUsername()));
        $rdv = $this->getDoctrine()->getRepository(RendezVous::class)->findOneBy(array('id'=>$id));

        return $this->render('rdv/adminRdv.html.twig',[
           'utilisateur' =>$user,
           'rdv' => $rdv
        ]);
    }

    /**
     * @Route("/rdv/removeRdv/{id}", name="removeRdvAdmin")
     */
    public function adminRemoveRdv(int $id){
        $user = $this->getDoctrine()->getRepository(Utilisateur::class)->findOneBy(array('email'=>$this->getUser()->getUsername()));
        $rdv = $this->getDoctrine()->getRepository(RendezVous::class)->findOneBy(array('id'=>$id));
        if($rdv->getPatient()->getId() == $user->getId()){
            $supp =1;
            $rdv->setStatus(1);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
        }

        return $this->render('rdv/adminRemoveRdv.html.twig',[
            'utilisateur' =>$user,
            'rdv' => $rdv,
            'supp' =>$supp
        ]);
    }

    /**
     * @Route("/rdv/acceptRdv/{id}", name="acceptRdvAdmin")
     */
    public function adminAcceptRdv(int $id){
        $user = $this->getDoctrine()->getRepository(Utilisateur ::class)->findOneBy(array('email'=>$this->getUser()->getUsername()));
        $rdv = $this->getDoctrine()->getRepository(RendezVous::class)->findOneBy(array('id'=>$id));
        if($rdv->getPatient()->getId() == $user->getId()){
            $supp =1;
            $rdv->setStatus(2);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
        }

        return $this->render('rdv/adminAcceptRdv.html.twig',[
            'utilisateur' =>$user,
            'rdv' => $rdv,
            'supp'=>$supp
        ]);
    }


    /**
     * @Route("/horraire/add", name="addHorraire")
     */
    public function addHorraire(Request $request){
        $user = $this->getDoctrine()->getRepository(Utilisateur ::class)->findOneBy(array('email'=>$this->getUser()->getUsername()));
        $form = $this->createForm(HorraireType::class);
        $form->handleRequest($request);
        $data=$form->getData();

        if($form->isSubmitted() && $form->isValid()){
            if($user->getHorraires() == null){
                $horraire = [];
            }else{
                $horraire = $user->getHorraires();
            }
            $horraire[$data['nomHoraire']] = $data['horaire'];
            $user->setHorraires($horraire);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
        }

        return $this->render('rdv/addHorraire.html.twig',[
            'utilisateur'=>$user,
            'form' => $form->createView(),
            'medecin' => $user
        ]);

    }

}
