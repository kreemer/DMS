<?php
/**
 * File
 *
 * User: kreemer <kreemer@me.com>
 * File: ResultTest.php
 * Date: 10.12.13
 * Time: 14:42
 */

namespace DMS\SystemBundle\Tests\Entity;


use DMS\SystemBundle\Entity\Result;

class ResultTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Result
     */
    private $object;

    /**
     * setUP
     *
     * @return void
     */
    public function setUp()
    {
        $this->object = new Result();
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
    public function getResult()
    {
        $this->object->setResult('42');
        $this->assertEquals('42', $this->object->getResult());
    }

    /**
     * @test
     *
     * @return void
     */
    public function getDuration()
    {
        $this->object->setDuration(1004);
        $this->assertEquals(1004, $this->object->getDuration());
    }

    /**
     * @test
     *
     * @return void
     */
    public function getBrowser()
    {
        $this->object->setBrowser('firefox');
        $this->assertEquals('firefox', $this->object->getBrowser());
    }

    /**
     * @test
     *
     * @return void
     */
    public function getIp()
    {
        $this->object->setIp('127.0.0.1');
        $this->assertEquals('127.0.0.1', $this->object->getIp());
    }
}
