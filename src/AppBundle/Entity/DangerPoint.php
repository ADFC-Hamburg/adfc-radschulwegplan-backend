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
use Jsor\Doctrine\PostGIS\Functions\Geometry;

/**
 * DangerPoint.
 *
 * @ORM\Table(name="danger_point")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DangerPointRepository")
 *
 * @JMS\ExclusionPolicy("all")
 */
class DangerPoint extends BaseEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @JMS\Expose(true)
     * @JMS\Groups({"role-admin", "path-danger_point-any"})
     */
    private $id;

    /**
     * @var Geometry
     *
     * @ORM\Column(name="pos", type="geometry",options={"geometry_type"="POINT", "srid"=4326})
     *
     * @JMS\Expose(true)
     * @JMS\Groups({"role-admin", "path-danger_point-any"})
     */
    private $pos;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=128)
     *
     * @JMS\Expose(true)
     * @JMS\Groups({"role-admin", "path-danger_point-any"})
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     *
     * @JMS\Expose(true)
     * @JMS\Groups({"role-admin", "path-danger_point-any"})
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="typeId", type="integer")
     *
     * @JMS\Expose(true)
     * @JMS\Groups({"role-admin", "path-danger_point-any"})
     */
    private $typeId;

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
     * @param geometry $pos
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
     * @return geometry
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
     * Set typeId.
     *
     * @param int $typeId
     *
     * @return DangerPoint
     */
    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;

        return $this;
    }

    /**
     * Get typeId.
     *
     * @return int
     */
    public function getTypeId()
    {
        return $this->typeId;
    }
}
