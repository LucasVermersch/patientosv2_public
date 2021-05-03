<?php

namespace App\Controller;

use App\Entity\Lit;
use App\Entity\Patient;
use App\Entity\Session;
use App\Form\LitType;
use App\Form\PatientModifType;
use App\Form\PatientType;
use App\Form\RegistrationFormType;
use App\Form\SessionType;
use App\LoggerPatientOS;
use Doctrine\DBAL\Types\IntegerType;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;


class PatientController extends AbstractController
{
    /**
     * @Route("/nouveauPatient", name="nouveauPatient")
     */
    public function nouveauPatient(Request $request): Response
    {
        $patient = new Patient();
        $form = $this -> createForm(PatientType::class,$patient);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Patient ajouté avec succès' );
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($patient);
            $entityManager->flush();
            $logger = new LoggerPatientOS();
            $logger->ajoutLogInfo($this->getUser()->getUsername(). " a ajouté le patient : " .$patient->getNom() . " " . $patient->getPrenom());

            return $this->redirectToRoute('voirPatient');
        }

        return $this->render('patient/formulaire.html.twig', [
            'patientForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/voirPatient", name="voirPatient")
     */
    public function voirPatient(): Response
    {

        if(empty($_POST['nom']) && empty($_POST['prenom'])){
            $patients = $this->getDoctrine()
                ->getManager()
                ->getRepository(Patient::class)
                ->searchClassique();
        }else{
            $patients = $this->getDoctrine()
                ->getManager()
                ->getRepository(Patient::class)
                ->search($_POST['nom'],$_POST['prenom']);
        }


        return $this->render('patient/voirPatient.html.twig', [
            'patients' => $patients
        ]);
    }

    /**
     * @route("/modifProfil", name="modificationProfil")
     */


    public function modifProfil(Request $request)
    {

        $patient = $this->getUser();

        $form = $this->createForm(PatientModifType::class,$patient);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($patient);
            $entityManager->flush();

        }


        return $this->render('registration/modifProfilPatient.html.twig', [
               'form' => $form->createView()

        ]);
    }


    /**
     * @Route("/voirPatient/{id}", name="modifierPatient")
     */
    public function modifierPatient(int $id,Request $request): Response
    {
        $patient = $this->getDoctrine()
            ->getManager()
            ->getRepository(Patient::class)
            ->findBy([
                'id' => $id
            ]);
        $form = $this ->createForm(PatientType::class,$patient[0]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $patient = $form->getData();
            $patient->setId($patient->getId());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($patient);
            $entityManager->flush();
            $logger = new LoggerPatientOS();
            $logger->ajoutLogInfo($this->getUser()->getUsername(). " a modifié le patient : " .$patient->getNom() . " " . $patient->getPrenom());
        }
        return $this->render('patient/modifierPatient.twig', [
            'patients' => $patient,
            'patientForm' => $form->createView()
        ]);
    }
}
