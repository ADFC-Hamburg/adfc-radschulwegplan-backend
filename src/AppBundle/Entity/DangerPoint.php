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

/**
 * DangerPoint.
 *
 * @ORM\Table(name="danger_point")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DangerPointRepository")
 */
class DangerPoint extends BaseEntity
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
     * @var Geometry
     *
     * @ORM\Column(name="pos", type="geometry",options={"geometry_type"="POINT", "srid"=4326})
     */
    private $pos;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=128)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="DangerType")
     * @ORM\JoinColumn(name="typeId", referencedColumnName="id", nullable=false)
     */
    private $type;

    /**
     * @var bool
     *
     * @ORM\Column(name="danger", type="boolean", nullable=false, options={"default" : false})
     */
    private $danger;

    /**
     * @var bool
     *
     * @ORM\Column(name="area", type="boolean", nullable=false, options={"default" : false})
     */
    private $area;

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
     * Set pos.
     *
     * @param Geometry $pos
     *
     * @return DangerPoint
     */
    public function setPos($pos)
    {
        $this->pos = $pos;

        return $this;
    }

    /**
     * Get pos.
     *
     * @return Geometry
     */
    public function getPos()
    {
        return $this->pos;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return DangerPoint
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return DangerPoint
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set type.
     *
     * @param int $type
     *
     * @return DangerPoint
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * IsArea.
     *
     * @return bool is true if this is an area or false if its is an point
     */
    public function isArea()
    {
        return $this->area;
    }

    /**
     * SetArea.
     *
     * @param bool $area if this is an area or false if it is an point
     *
     * @return DangerPoint
     */
    public function setArea(bool $area)
    {
        $this->area = $area;

        return $this;
    }

    /**
     * IsDanger
     * is this a danger-Area or (only) a problem?
     *
     *
     * @return bool
     */
    public function isDanger()
    {
        return $this->danger;
    }

    /**
     * SetArea.
     *
     * @param bool $area set true if it is dangurous
     *
     * @return DangerPoint
     */
    public function setDanger(bool $danger)
    {
        $this->danger = $danger;

        return $this;
    }
}
