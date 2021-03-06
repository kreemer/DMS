<?php
/**
 * File
 *
 * User: kreemer <kreemer@me.com>
 * File: Manager.php
 * Date: 28.08.13
 * Time: 19:04
 */

namespace DMS\SystemBundle\Instruction;

use Doctrine\ORM\EntityManager;
use DMS\SystemBundle\Instruction;

/**
 * Class Manager
 *
 * @package DMS\SystemBundle\Instruction
 */
class Manager
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    /**
     * @return Instruction
     */
    public function getNextInstruction() {
        $repo = $this->em->getRepository('DMSSystemBundle:Task');
        $task = $repo->findNextTask();
        if ($task != null) {
            $inst = new Instruction($task->getId());
            $inst->setEquation($task->getMath())->setStep($task->getStep());
        } else {
            $inst = new Instruction(0);
            $inst->setEquation('1+1')->setStep(0);
        }

        return $inst;
    }
}