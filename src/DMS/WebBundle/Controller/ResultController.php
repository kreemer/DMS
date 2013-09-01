<?php

namespace DMS\WebBundle\Controller;

use DMS\SystemBundle\Entity\Result;
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
        if ($_POST['id'] == 0) {
            return new Response("");
        }
        $em = $this->getDoctrine()->getManager();
        $task = $em->getRepository('DMSSystemBundle:Task')->find($_POST['id']);
        $result = new Result();
        $result->setTask($task);
        $result->setResult($_POST['data']);
        $em->persist($result);
        $task->setCalculated(true);
        $em->persist($task);
        $em->flush();

        return new Response("");
    }
}
