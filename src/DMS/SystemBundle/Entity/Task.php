<?php

namespace DMS\SystemBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Task
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DMS\SystemBundle\Entity\TaskRepository")
 */
class Task
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
     * @var Equation
     *
     * @ORM\ManyToOne(targetEntity="Equation", inversedBy="tasks")
     */
    private $equation;

    /**
     * @var string
     *
     * @ORM\Column(name="math", type="text")
     */
    private $math;

    /**
     * @var integer
     *
     * @ORM\Column(name="step", type="integer")
     */
    private $step;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $calculated = false;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Result", mappedBy="task")
     */
    private $results;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->results = new ArrayCollection();
    }

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
     * Set math
     *
     * @param string $math
     * @return Task
     */
    public function setMath($math)
    {
        $this->math = $math;

        return $this;
    }

    /**
     * Get math
     *
     * @return string
     */
    public function getMath()
    {
        return $this->math;
    }

    /**
     * Set step
     *
     * @param integer $step
     * @return Task
     */
    public function setStep($step)
    {
        $this->step = $step;

        return $this;
    }

    /**
     * Get step
     *
     * @return integer
     */
    public function getStep()
    {
        return $this->step;
    }

    /**
     * @param \DMS\SystemBundle\Entity\Equation $equation
     *
     * @return Task
     */
    public function setEquation(Equation $equation)
    {
        $this->equation = $equation;

        return $this;
    }

    /**
     * @return \DMS\SystemBundle\Entity\Equation
     */
    public function getEquation()
    {
        return $this->equation;
    }

    /**
     * @param boolean $calculated
     *
     * @return Task
     */
    public function setCalculated($calculated)
    {
        $this->calculated = $calculated;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getCalculated()
    {
        return $this->calculated;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getResults()
    {
        return $this->results;
    }
}
