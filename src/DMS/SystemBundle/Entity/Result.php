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
}
