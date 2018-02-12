<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SchoolClass
 *
 * @ORM\Table(name="school_class",uniqueConstraints={@ORM\UniqueConstraint(name="school_class_idx", columns={"name", "school"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SchoolClassRepository")
 */
class SchoolClass
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=16)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="School")
     * @ORM\JoinColumn(name="school", referencedColumnName="id")
     */
    private $school;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastChange", type="datetime")
     */
    private $lastChange;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="changed_by", referencedColumnName="id")
     */
    private $changedBy;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     */
    private $createdBy;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return SchoolClass
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set school
     *
     * @param integer $school
     *
     * @return SchoolClass
     */
    public function setSchool($school)
    {
        $this->school = $school;

        return $this;
    }

    /**
     * Get school
     *
     * @return int
     */
    public function getSchool()
    {
        return $this->school;
    }

    /**
     * Set lastChange
     *
     * @param \DateTime $lastChange
     *
     * @return SchoolClass
     */
    public function setLastChange($lastChange)
    {
        $this->lastChange = $lastChange;

        return $this;
    }

    /**
     * Get lastChange
     *
     * @return \DateTime
     */
    public function getLastChange()
    {
        return $this->lastChange;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return SchoolClass
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set changedBy
     *
     * @param integer $changedBy
     *
     * @return SchoolClass
     */
    public function setChangedBy($changedBy)
    {
        $this->changedBy = $changedBy;

        return $this;
    }

    /**
     * Get changedBy
     *
     * @return int
     */
    public function getChangedBy()
    {
        return $this->changedBy;
    }

    /**
     * Set createdBy
     *
     * @param integer $createdBy
     *
     * @return SchoolClass
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return int
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }
}

