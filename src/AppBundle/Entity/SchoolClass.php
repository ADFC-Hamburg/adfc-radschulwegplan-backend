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

use Doctrine\ORM\Mapping as ORM;
use Swagger\Annotations as SWG;

/**
 * SchoolClass.
 *
 * @ORM\Table(name="school_class",uniqueConstraints={@ORM\UniqueConstraint(name="school_class_idx", columns={"name", "school"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SchoolClassRepository")
 * @SWG\Definition(definition="SchoolClass")
 */
class SchoolClass extends BaseEntity
{
    /**
     * @var int the id of the class
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @SWG\Property(description="The unique identifier of the class.")
     */
    private $id;

    /**
     * @var string the name of the class
     *
     * @ORM\Column(name="name", type="string", length=16)
     * @SWG\Property(type="string", maxLength=16)
     */
    private $name;

    /**
     * @var int corosponding school
     *
     * @ORM\ManyToOne(targetEntity="School")
     * @ORM\JoinColumn(name="school", referencedColumnName="id", nullable=false)
     */
    private $school;

    public function __construct()
    {
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
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
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set school.
     *
     * @param int $school
     *
     * @return SchoolClass
     */
    public function setSchool($school)
    {
        $this->school = $school;

        return $this;
    }

    /**
     * Get school.
     *
     * @return int
     */
    public function getSchool()
    {
        return $this->school;
    }
}
