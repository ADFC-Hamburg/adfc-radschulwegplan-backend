<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SchoolWay
 *
 * @ORM\Table(name="school_way")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SchoolWayRepository")
 */
class SchoolWay extends BaseEntity
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
     * @var geometry
     *
     * @ORM\Column(name="way", type="geometry",options={"geometry_type"="LINESTRING", "srid"=4326})
     */
    private $way;

    /**
     * @var int
     *
     * @ORM\Column(name="wayType", type="integer")
     */
    private $wayType;

    /**
     * @var int
     *
     * @ORM\Column(name="year", type="integer")
     */
    private $year;


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
     * Set way
     *
     * @param geometry $way
     *
     * @return SchoolWay
     */
    public function setWay($way)
    {
        $this->way = $way;

        return $this;
    }

    /**
     * Get way
     *
     * @return geometry
     */
    public function getWay()
    {
        return $this->way;
    }

    /**
     * Set wayType
     *
     * @param integer $wayType
     *
     * @return SchoolWay
     */
    public function setWayType($wayType)
    {
        $this->wayType = $wayType;

        return $this;
    }

    /**
     * Get wayType
     *
     * @return int
     */
    public function getWayType()
    {
        return $this->wayType;
    }

    /**
     * Set wayType
     *
     * @param integer $wayType
     *
     * @return SchoolWay
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get wayType
     *
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }
}

