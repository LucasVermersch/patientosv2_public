<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Entity\Sejour;
use App\Form\PatientLitType;
use App\Form\SejourType;
use App\LoggerPatientOS;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SejourController extends AbstractController
{
    /**
     * @Route("/sejourAjouter", name="sejourAjouter")
     */
    public function sejourAjouter(): Response
    {
        if(empty($_POST['nom']) && empty($_POST['prenom'])){
            $patients = $this->getDoctrine()
                ->getManager()
                ->getRepository(Patient::class)
                ->searchClassiqueSejour();
        }else{
            $patients = $this->getDoctrine()
                ->getManager()
                ->getRepository(Patient::class)
                ->searchSejour($_POST['nom'],$_POST['prenom']);
        }

        return $this->render('sejour/voirSejourAjouter.html.twig', [
            'patients' => $patients
        ]);
    }
    /**
     * @Route("/sejourAjouter/{id}", name="sejourAjouterUtilisateur")
     */
    public function sejourAjouterUtilisateur(int $id, Request $request): Response
    {
        $sejour = new Sejour();
        /** @var Patient $patient */
        $patient = $this->getDoctrine()->getManager()->getRepository(Patient::class)->find($id);
        $sejour->setPatient($patient);
        $sejour->setService($patient->getService());
        $formPatient = $this->createForm(SejourType::class,$sejour);
        $formLitPatient = $this->createForm(PatientLitType::class,$patient,['nomService' => $patient->getService()->getNomService()]);
        $formPatient->handleRequest($request);

        if ($formPatient->isSubmitted() && $formPatient->isValid()) {
            $this->addFlash('success', 'Séjour ajouté avec succès' );
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sejour);
            $entityManager->flush();
        }
        $formLitPatient->handleRequest($request);
        if ($formLitPatient->isSubmitted() && $formLitPatient->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $patient->getLit()->setOccupation(true);
            $entityManager->persist($patient);
            $entityManager->flush();
            $logger = new LoggerPatientOS();
            $logger->ajoutLogInfo($this->getUser()->getUsername(). " a ajouté le sejour du patient : " . $sejour->getPatient()->getNom() . " " . $sejour->getPatient()->getPrenom() );

        return $this->redirectToRoute('sejourAjouter');
        }


        return $this->render('sejour/ajouterSejour.html.twig', [
            'sejourForm' => $formPatient->createView(),
            'formLitPatient' => $formLitPatient->createView()
        ]);
    }

    /**
     * @Route("/purge", name="purgeSejour")
     */
    public function purgeSejourEtLit( Request $request): Response
    {
        /** @var Sejour $sejours */
        $sejours = $this->getDoctrine()->getManager()->getRepository(Sejour::class)->searchPurge();

        foreach($sejours as $sejour){
            $patient = $sejour->getPatient();
            $patient->getLit()->setOccupation(false);
            $patient->setLit(Null);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($patient);
            $entityManager->flush();
        }
        return $this->render('service/purge.html.twig', [

        ]);
    }
}
