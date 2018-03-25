<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * @var School
     *
     * School
     *
     * @ORM\ManyToOne(targetEntity="School")
     * @ORM\JoinColumn(name="school_id", referencedColumnName="id", nullable=true)
     */
    private $school;

    /**
     * @var SchoolClass
     *
     * SchoolClass
     *
     * @ORM\ManyToOne(targetEntity="SchoolClass")
     * @ORM\JoinColumn(name="school_class_id", referencedColumnName="id", nullable=true)
     */
    private $schoolClass;

    /**
     * getSchool
     *
     * @return School
     */
    public function getSchool()
    {
        return $this->school;
    }

    /**
     * hasSchool
     *
     * @return boolean
     */
    public function hasSchool()
    {
        return is_null($this->school);
    }

    /**
     * getSchoolClass
     *
     * @return SchoolClass
     */
    public function getSchoolClass()
    {
        return $this->schoolClass;
    }

    /**
     * setSchool
     *
     * @return User
     */
    public function setSchool($school)
    {
        if ((!is_null($this->schoolClass)) && ($this->schoolClass->getId() != $this->school->getId())) {
            throw new SchoolSchoolClassMismatchException($this->school->getId(), $this->schoolClass->getId());
        }
        $this->school=$school;
       
        return $this;
    }

    
    /**
     * setSchoolClass (sets school too)
     *
     * @return User
     */
    public function setSchoolClass($schoolClass)
    {
        $this->schoolClass=$schoolClass;
        $this->school=$scholClass->getSchool();
        return $this;
    }

}
