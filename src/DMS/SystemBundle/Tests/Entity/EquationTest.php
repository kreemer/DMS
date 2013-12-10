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
use Doctrine\Common\Collections\ArrayCollection;

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
        $this->assertNull($this->object->getId());
    }

    /**
     * @test
     *
     * @return void
     */
    public function getTitle()
    {
        $this->object->setTitle('test');
        $this->assertEquals('test', $this->object->getTitle());
    }

    /**
     * @test
     *
     * @return void
     */
    public function getFile()
    {
        $this->object->setFile('/tmp/test');
        $this->assertEquals('/tmp/test', $this->object->getFile());
    }

    /**
     * @test
     *
     * @return void
     */
    public function getTasks()
    {
        $this->assertTrue($this->object->getTasks() instanceof ArrayCollection);
    }
}
