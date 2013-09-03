<?php
/**
 * File
 *
 * User: kreemer <kreemer@me.com>
 * File: Variable.php
 * Date: 03.09.13
 * Time: 07:48
 */

namespace DMS\SystemBundle\Parser;

/**
 * Class Variable
 * @package DMS\SystemBundle\Parser
 */
class Variable
{
    /**
     * @var
     */
    protected $name;

    /**
     * @var
     */
    protected $value;

    /**
     * @param $name
     * @param $value
     */
    function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @param mixed $name
     *
     * @return Variable
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $value
     *
     * @return Variable
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }


}