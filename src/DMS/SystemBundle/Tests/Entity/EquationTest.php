<?php
/**
 * File
 *
 * User: kreemer <kreemer@me.com>
 * File: EquationTest.php
 * Date: 10.12.13
 * Time: 09:57
 */

namespace DMS\SystemBundle\Tests\Entity;


use DMS\SystemBundle\Entity\Equation;

class EquationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Equation
     */
    private $object;

    /**
     * setUP
     *
     * @return void
     */
    public function setUp()
    {
        $this->object = new Equation();
    }

    /**
     * @test
     *
     * @return void
     */
    public function getId()
    {
        $this->object->getId();
    }
}
