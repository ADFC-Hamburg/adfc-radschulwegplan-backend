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
use JMS\Serializer\Annotation as JMS;
use Swagger\Annotations as SWG;

/**
 * School.
 *
 * @ORM\Table(name="school")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SchoolRepository")
 *
 * @JMS\ExclusionPolicy("all")
 */
class School extends BaseEntity
{
    /**
     * @var int Identify
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @SWG\Property(format="int64")
     *
     * @JMS\Expose(true)
     * @JMS\Groups({"any"})
     */
    private $id;

    /**
     * @var string Name of the school
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @SWG\Property(format="string")
     *
     * @JMS\Expose(true)
     * @JMS\Groups({"any"})
     */
    private $name;

    /**
     * @var string Street including housnumber
     *
     * @ORM\Column(name="street", type="string", length=255)
     * @SWG\Property(format="string")
     *
     * @JMS\Expose(true)
     * @JMS\Groups({"role-admin"})
     */
    private $street;

    /**
     * @var string Postal Code of the place, where the school is. Shall be a number with 5 digits as  a string.
     *
     * @ORM\Column(name="postalcode", type="string", length=5)
     * @SWG\Property(format="string")
     *
     * @JMS\Expose(true)
     * @JMS\Groups({"any"})
     */
    private $postalcode;

    /**
     * @var string place of the school
     *
     * @ORM\Column(name="place", type="string", length=64)
     * @SWG\Property(format="string")
     *
     * @JMS\Expose(true)
     * @JMS\Groups({"any"})
     */
    private $place;

    /**
     * @var string If the school has an homepage, please provide the url
     *
     * @ORM\Column(name="webpage", type="string", length=255, nullable=true)
     * @SWG\Property(format="string")
     *
     * @JMS\Expose(true)
     * @JMS\Groups({"any"})
     */
    private $webpage;

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
     * @param string $name New Name
     *
     * @return School
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
     * Set street.
     *
     * @param string $street New Street
     *
     * @return School
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street.
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set postalcode.
     *
     * @param string $postalcode new postal code
     *
     * @return School
     */
    public function setPostalcode($postalcode)
    {
        $this->postalcode = $postalcode;

        return $this;
    }

    /**
     * Get postalcode.
     *
     * @return string
     */
    public function getPostalcode()
    {
        return $this->postalcode;
    }

    /**
     * Set place.
     *
     * @param string $place new place
     *
     * @return School
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place.
     *
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set webpage.
     *
     * @param string $webpage
     *
     * @return School
     */
    public function setWebpage($webpage)
    {
        $this->webpage = $webpage;

        return $this;
    }

    /**
     * Get webpage.
     *
     * @return string
     */
    public function getWebpage()
    {
        return $this->webpage;
    }
}
