<?php
/**
 * File
 *
 * User: kreemer <kreemer@me.com>
 * File: Loop.php
 * Date: 07.10.13
 * Time: 11:12
 */

namespace DMS\SystemBundle\Token;

/**
 * Class Loop
 *
 * @package DMS\SystemBundle\Token
 */
class Loop extends Collection
{
    /**
     * @var string
     */
    protected $loopVar;

    /**
     * @var int
     */
    protected $start;

    /**
     * @var int
     */
    protected $end;

    /**
     * @var int
     */
    protected $step;

    /**
     * @var array
     */
    protected $lines = array();

    function __construct($loopVar, $start, $end, $step = 1)
    {
        $this->loopVar = $loopVar;
        $this->start = $start;
        $this->end = $end;
        $this->step = $step;
    }

    /**
     * @return int
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @return string
     */
    public function getLoopVar()
    {
        return $this->loopVar;
    }

    /**
     * @return int
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @return int
     */
    public function getStep()
    {
        return $this->step;
    }
}