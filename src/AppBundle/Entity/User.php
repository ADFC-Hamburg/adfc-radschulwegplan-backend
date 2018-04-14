<?php

/*
 * This file is part of the ADFC Radschulwegplan Backend package.
 *
 * <https://github.com/ADFC-Hamburg/adfc-radschulwegplan-backend>
 *
 * (c) 2018 by James Twellmeyer <jet02@twellmeyer.eu>
 * (c) 2018 by Sven Anders <github2018@sven.anders.hamburg>
 *
 * Released under the GPL 3.0
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Please also visit our (german) webpage about the project:
 *
 * <https://hamburg.adfc.de/verkehr/themen-a-z/kinder/schulwegplanung/>
 *
 */

namespace AppBundle\Entity;

use AppBundle\Exception\SchoolSchoolClassMismatchException;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as FOSUser;
use JMS\Serializer\Annotation as JMS;

/**
 * User.
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 *
 * @JMS\ExclusionPolicy("all")
 */
class User extends FOSUser
{
    /**
     * @var int id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @JMS\Expose(true)
     * @JMS\Groups({"any"})
     */
    protected $id;

    /**
     * @var School
     *
     * School
     *
     * @ORM\ManyToOne(targetEntity="School")
     * @ORM\JoinColumn(name="school_id", referencedColumnName="id", nullable=true)
     *
     * @JMS\Expose(true)
     * @JMS\Groups({"role-admin"})
     */
    private $school = null;

    /**
     * @var SchoolClass
     *
     * SchoolClass
     *
     * @ORM\ManyToOne(targetEntity="SchoolClass")
     * @ORM\JoinColumn(name="school_class_id", referencedColumnName="id", nullable=true)
     *
     * @JMS\Expose(true)
     * @JMS\Groups({"role-admin"})
     */
    private $schoolClass = null;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * getSchool.
     *
     * @return School a school associated to the user or NULL, if there is no school associated
     */
    public function getSchool()
    {
        return $this->school;
    }

    /**
     * hasSchool.
     *
     * @return bool is a school associated?
     */
    public function hasSchool()
    {
        return !is_null($this->school);
    }

    /**
     * isInSchool.
     *
     * @param School|int $school
     *
     * @return bool is the user in this school?
     */
    public function isInSchool($school)
    {
        if ($this->hasSchool()) {
            if ($school instanceof School) {
                $school = $school->getId();
            }

            return $this->school->getId() == $school;
        } // else

        return false;
    }

    /**
     * getSchoolClass.
     *
     * @return SchoolClass
     */
    public function getSchoolClass()
    {
        return $this->schoolClass;
    }

    /**
     * setSchool.
     *
     * @return User
     */
    public function setSchool($school)
    {
        if ((!is_null($this->schoolClass)) && ($this->schoolClass->getSchool()->getId() != $school->getId())) {
            throw new SchoolSchoolClassMismatchException($school->getId(), $this->schoolClass->getSchool()->getId());
        }
        $this->school = $school;

        return $this;
    }

    /**
     * setSchoolClass (sets school too).
     *
     * @return User
     */
    public function setSchoolClass($schoolClass)
    {
        $this->schoolClass = $schoolClass;
        $this->school = $schoolClass->getSchool();

        return $this;
    }
}
