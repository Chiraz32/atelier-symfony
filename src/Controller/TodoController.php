<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    #[Route('/todo', name: 'app_todo')]
    public function index(SessionInterface $session): Response
    {  if (! $session->has('todo'))

        {
        $session->set('todo',
        ['achat'=>"achater clé USB",
            'arrangement'=>"arranger rendez-vous",
            "rediger"=>"rediger un mail"]);

        }

        return $this->render('todo/index.html.twig', [
            'controller_name' => 'TodoController',
        ]);

    }
    #[Route('/todo/addtodo/{title}/{action}', name: 'app_addtodo')]
    public function add(SessionInterface $session,$title,$action): RedirectResponse
    {
        if ( $session->has('todo')) {


            $newtodo = $session->get('todo');

            if (isset( $newtodo[$title] ))
            {  $this->addFlash('danger',
                "la todo existe déjà  ");

            }else {

                $newtodo[$title] = $action;
                $session->set('todo', $newtodo);
                $this->addFlash('success',
                    "le todo vient d'etre  ajouté");}


        } else {

            $this->addFlash('info',
                "la liste n'est pas encore  initialisée");
        }


        return $this->redirectToRoute("app_todo")
            ;
    }

    #[Route('/todo/modif/{title}/{action}', name: 'app_modiftodo')]
    public function modif(SessionInterface $session,$title,$action): RedirectResponse
    {
        if ( $session->has('todo')) {


            $newtodo = $session->get('todo');

            if (!isset( $newtodo[$title] ))
            {  $this->addFlash('danger ',
                "la todo n'existe pas dans la liste ");

            }else {

                $newtodo[$title] = $action;
                $session->set('todo', $newtodo);
                $this->addFlash('success',
                    "le todo a été modifié");}


        } else {

            $this->addFlash('info ',
                "la liste n'est pas encore  initialisée");
        }


        return $this->redirectToRoute("app_todo")
            ;
    }
    #[Route('/todo/supp/{title}', name: 'app_supptodo')]
    public function supp(SessionInterface $session,$title):RedirectResponse
    {
        if ( $session->has('todo')) {


            $newtodo = $session->get('todo');

            if (!isset( $newtodo[$title] ))
            {  $this->addFlash('danger ',
                "la todo n'existe pas dans la liste ");

            }else {

                unset($newtodo[$title] );
                $session->set('todo', $newtodo);
                $this->addFlash('success',
                    "le todo a été supprimé  ");}


        } else {

            $this->addFlash('info ',
                "la liste n'est pas encore  initialisée");
        }


        return $this->redirectToRoute("app_todo")
            ;
    }
    #[Route('/todo/reset', name: 'app_resettodo')]
    public function reset(SessionInterface $session): RedirectResponse
{



      $session->remove('todo');



    return $this->redirectToRoute("app_todo")
        ;
} }







