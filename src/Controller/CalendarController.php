<?php

namespace App\Controller;

use App\Entity\Calendar;
use App\Entity\RendezVous;
use App\Form\CalendarType;
use App\Form\RendezVousType;
use App\Repository\CalendarRepository;
use App\Repository\RendezVousRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/calendar")
 */
class CalendarController extends AbstractController
{
    /**
     * @Route("/", name="calendar_index", methods={"GET"})
     */
    public function index(RendezVousRepository $calendarRepository): Response
    {
        return $this->render('calendar/index.html.twig', [
            'calendars' => $calendarRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="calendar_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $rdv = new RendezVous();
        $form = $this->createForm(RendezVousType::class, $rdv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rdv);
            $entityManager->flush();

            return $this->redirectToRoute('calendar_index');
        }

        return $this->render('calendar/new.html.twig', [
            'calendar' => $rdv,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="calendar_show", methods={"GET"})
     */
    public function show(RendezVous $rendezVous): Response
    {
        return $this->render('calendar/show.html.twig', [
            'calendar' => $rendezVous,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="calendar_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, RendezVous $rendezVous): Response
    {
        $form = $this->createForm(RendezVousType::class, $rendezVous);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('calendar_index');
        }

        return $this->render('calendar/edit.html.twig', [
            'calendar' => $rendezVous,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="calendar_delete", methods={"DELETE"})
     */
    public function delete(Request $request, RendezVous $rendezVous): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rendezVous->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rendezVous);
            $entityManager->flush();
        }

        return $this->redirectToRoute('calendar_index');
    }
}
