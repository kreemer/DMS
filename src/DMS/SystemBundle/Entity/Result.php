<?php

namespace DMS\SystemBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Result
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DMS\SystemBundle\Entity\ResultRepository")
 */
class Result
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Task
     *
     * @ORM\ManyToOne(targetEntity="Task", inversedBy="results")
     */
    private $task;

    /**
     * @var integer
     *
     * @ORM\Column(name="result", type="float")
     */
    private $result;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=255)
     */
    private $ip;

    /**
     * Duration in miliseconds
     * @var int
     *
     * @ORM\Column(name="duration", type="integer")
     */
    private $duration;

    /**
     * @var string
     *
     * @ORM\Column(name="browser", type="string", length=255)
     */
    private $browser;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $result
     *
     * @return Result
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * @return int
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param \DMS\SystemBundle\Entity\Task $task
     *
     * @return Result
     */
    public function setTask(Task $task)
    {
        $this->task = $task;

        return $this;
    }

    /**
     * @return \DMS\SystemBundle\Entity\Task
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * @param string $browser
     *
     * @return Result
     */
    public function setBrowser($browser)
    {
        $this->browser = $browser;

        return $this;
    }

    /**
     * @return string
     */
    public function getBrowser()
    {
        return $this->browser;
    }

    /**
     * @param int $duration
     *
     * @return Result
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return int
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param string $ip
     *
     * @return Result
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }
}
