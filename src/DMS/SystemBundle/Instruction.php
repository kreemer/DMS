<?php
/**
 * File
 *
 * User: kreemer <kreemer@me.com>
 * File: Instruction.php
 * Date: 28.08.13
 * Time: 19:06
 */

namespace DMS\SystemBundle;

/**
 * Class Instruction
 *
 * @package DMS\SystemBundle
 */
class Instruction
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $equation;

    /**
     * @var int
     */
    private $step;

    /**
     * @param $id
     */
    function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $equation
     *
     * @return Instruction
     */
    public function setEquation($equation)
    {
        $this->equation = $equation;

        return $this;
    }

    /**
     * @return string
     */
    public function getEquation()
    {
        return $this->equation;
    }

    /**
     * @param int $step
     *
     * @return Instruction
     */
    public function setStep($step)
    {
        $this->step = $step;

        return $this;
    }

    /**
     * @return int
     */
    public function getStep()
    {
        return $this->step;
    }
}