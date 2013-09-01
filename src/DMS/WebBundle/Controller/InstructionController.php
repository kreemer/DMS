<?php

namespace DMS\WebBundle\Controller;

use DMS\SystemBundle\Instruction\Manager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class InstructionController extends Controller
{
    /**
     * @Route("/Instruction", name="instruction")
     */
    public function indexAction()
    {
        $manager = new Manager($this->getDoctrine()->getManager());
        $inst = $manager->getNextInstruction();

        return new Response('{ "math": "' . $inst->getEquation() .'", "step": "' . $inst->getStep() .'", "id": "'. $inst->getId() . '" }');
    }
}
