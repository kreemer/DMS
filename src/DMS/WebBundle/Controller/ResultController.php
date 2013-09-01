<?php

namespace DMS\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class ResultController extends Controller
{
    /**
     * @Route("/Result", name="result")
     */
    public function indexAction()
    {
        return new Response("");
    }
}
