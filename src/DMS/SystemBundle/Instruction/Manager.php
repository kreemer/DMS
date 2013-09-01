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
        $inst = new Instruction(1);
        $inst->setEquation('4+3-2')->setStep(1);

        return $inst;
    }
}