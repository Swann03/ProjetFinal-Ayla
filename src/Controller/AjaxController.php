<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

// imports
use Symfony\Component\HttpFoundation\Request;
final class AjaxController extends AbstractController
{
    #[Route('/ajax/form/independant', name: 'app_ajax_form_independant')]
    public function formIndependant(): Response
    {
        return $this->render('ajax/form_independant.html.twig');
    }

    #[Route('/ajax/form/independant/traitement', name: 'app_ajax_form_independant_traitement')]
    public function formIndependantTraitement(Request $req): Response
    {
        dd('Hello');
    }
}
