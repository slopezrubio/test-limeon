<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ActionController extends AbstractController
{
    /**
     * @Route("/", name="task")
     */
    public function index()
    {
        return $this->render('layouts/app.html.twig');
    }
}
