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
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User.
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

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * getSchool.
     *
     * @return School
     */
    public function getSchool()
    {
        return $this->school;
    }

    /**
     * hasSchool.
     *
     * @return bool
     */
    public function hasSchool()
    {
        return is_null($this->school);
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
