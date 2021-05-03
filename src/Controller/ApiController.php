<?php

namespace App\Controller;

use Doctrine\DBAL\Types\DateTimeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @Route("/api", name="api")
     */
    public function index(): Response
    {
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }

    /**
     * @Route("/api/{id}/edit", name="api_event_edit", methods={"PUT"})
     */
    public function majEvent(?Calendar $calendar, Request $request)
    {
        // recuperation les données
        $donnees = json_decode($request->getContent());

        if(
            isset($donnees->title) && !empty($donnees->title) &&
            isset($donnees->start) && !empty($donnees->start) &&
            isset($donnees->description) && !empty($donnees->description) &&
            isset($donnees->backgroundColor) && !empty($donnees->backgroundColor) &&
            isset($donnees->borderColor) && !empty($donnees->borderColor) &&
            isset($donnees->textColor) && !empty($donnees->textColor)
        ){
            // Les donnees sont complètes
            // on initialise un code
            $code = 200;

            // check si l'id existe
            if(!$calendar){
                // on instancie un rdv
                $calendar = new Calendar;
                // on change le code vers code 201 created
                $code = 201;
            }
            // remplissage de l'objet , hydratation
            $calendar->setTitle($donnees->title);
            $calendar->setDescription($donnees->description);
            $calendar->setStart(new DateTime($donnees->start));
            if($donnees->allDay){
                $calendar->setEnd(new DateTime($donnees->start));
            }else{
                $calendar->setEnd(new DateTime($donnees->end));
            }
            $calendar->setAllDay($donnees->allDay);
            $calendar->setBackgroundColor($donnees->backgroundColor);
            $calendar->setBorderColor($donnees->borderColor);
            $calendar->setTextcolor($donnees->textColor);

            $em = $this->getDoctrine()->getManager();
            $em->persist($calendar);
            $em->flush();

            //on retourne le code
            return new Response('ok',$code);



        }else{
            // Les données sont incomplètes
            return new Response('Données incomplètes', 404);
        }


    //    return $this->render('api/index.html.twig', [
    //        'controller_name' => 'ApiController',
    //    ]);
    }
}
