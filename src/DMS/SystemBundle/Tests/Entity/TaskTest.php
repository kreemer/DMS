<?php
/**
 * File
 *
 * User: kreemer <kreemer@me.com>
 * File: TaskTest.php
 * Date: 10.12.13
 * Time: 14:39
 */

namespace DMS\SystemBundle\Tests\Entity;

use DMS\SystemBundle\Entity\Task;

class TaskTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Task
     */
    private $object;

    /**
     * setUP
     *
     * @return void
     */
    public function setUp()
    {
        $this->object = new Task();
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
    public function getMath()
    {
        $this->object->setMath('1+1');
        $this->assertEquals('1+1', $this->object->getMath());
    }

    /**
     * @test
     *
     * @return void
     */
    public function getCalculated()
    {
        $this->assertFalse($this->object->getCalculated());
        $this->object->setCalculated(true);
        $this->assertTrue($this->object->getCalculated());
    }

    /**
     * @test
     *
     * @return void
     */
    public function getStep()
    {
        $this->object->setStep(3);
        $this->assertEquals(3, $this->object->getStep());
    }
}
