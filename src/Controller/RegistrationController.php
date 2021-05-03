<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Entity\Utilisateur;
use App\Form\PatientRegistrationType;
use App\Form\RegistrationFormType;
use App\LoggerPatientOS;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Symfony\Component\String\Slugger\SluggerInterface;


class RegistrationController extends AbstractController
{
    private $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    /**
     * @Route("/inscriptionSoignant", name="inscriptionSoignant")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new Utilisateur();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Soignant ajouté avec succès' );
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            if ($user->getService()->getNomService()=="Administration"){
                $roles = ["ROLE_ADMIN"];
                $user->setRoles($roles);
            }else{
                $roles = ["ROLE_SOIGNANT"];
                $user->setRoles($roles);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $logger = new LoggerPatientOS();
            $logger->ajoutLogInfo($this->getUser()->getUsername(). " a ajouté le soignant : " . $user->getNom() . " " . $user->getPrenom() );

            // generate a signed url and email it to the user
            return $this->redirectToRoute('administrateur');

        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            'navbar' => true
        ]);
    }


    /**
     * @Route("/inscription", name="inscriptionPatient")
     */
    public function registerPatient(Request $request, UserPasswordEncoderInterface $passwordEncoder,SluggerInterface $slugger)
    {
        $patient = new Patient();
        $form = $this->createForm(PatientRegistrationType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Inscription validée !' );
            //On récupère la photo
            $photoUrl = $form->get("photoUrl")->getData();
            if ($photoUrl) {
                $photoUrlFileName = pathinfo($photoUrl->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($photoUrlFileName);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photoUrl->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $photoUrl->move(
                        $this->getParameter('pp_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'Un problème est survenu lors du chargement de l\' image ' );
                }

                $patient->setPhotoUrl($newFilename);
            }

            // encode the plain password
            $patient->setPassword(
                $passwordEncoder->encodePassword(
                    $patient,
                    $form->get('plainPassword')->getData()
                )
            );
            $roles = ["ROLE_PATIENT"];
            $patient->setRoles($roles);


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($patient);
            $entityManager->flush();
            $logger = new LoggerPatientOS();
            $logger->ajoutLogInfo(  $patient->getNom() . " " . $patient->getPrenom() . " vient de s'inscrire !" );

            // generate a signed url and email it to the user
            return $this->redirectToRoute('app_login');

        }

        return $this->render('registration/registerPatient.html.twig', [
            'registrationForm' => $form->createView(),
            'navbar' => true
        ]);
    }



    /**
     * @Route("/verify/email", name="app_verify_email")
     */
    public function verifyUserEmail(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_register');
    }
}
