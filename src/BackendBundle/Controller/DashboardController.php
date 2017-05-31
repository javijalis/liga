<?php

namespace BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DashboardController extends Controller
{
    /**
     * @Route("/")
     */
    public function dashboardAction()
    {
        return $this->render('BackendBundle:Dashboard:dashboard.html.twig');
    }
}
