<?php

namespace DMS\AdminBundle\Controller;

use DMS\SystemBundle\Entity\Equation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="admin_index")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $equations = $em->getRepository('DMSSystemBundle:Equation')->findAll();

        return array('equations' => $equations);
    }

    /**
     * @Route("/detail/{id}", name="equation_detail")
     * @Template()
     */
    public function detailAction(Equation $equation)
    {
        $resultsAsJS = '';
        $u = 0;
        foreach ($equation->getTasks() as $task) {
            $results = $task->getResults();
            foreach ($results as $result) {
                if ($resultsAsJS != '') {
                    $resultsAsJS .= ',';
                }
                $resultsAsJS .= '[' . $u . ', ' . $result->getResult() . ']';
            }
            $u++;
        }

        return array('equation' => $equation, 'resultsAsJS' => $resultsAsJS);
    }
}
