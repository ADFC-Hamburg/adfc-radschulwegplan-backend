<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SchoolClass
 *
 * @ORM\Table(name="school_class",uniqueConstraints={@ORM\UniqueConstraint(name="school_class_idx", columns={"name", "school"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SchoolClassRepository")
 */
class SchoolClass extends BaseEntity
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

}

