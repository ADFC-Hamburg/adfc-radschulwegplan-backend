<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DangerPoint
 *
 * @ORM\Table(name="danger_point")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DangerPointRepository")
 */
class DangerPoint
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
     * @ORM\Column(name="pos", type="geometry",options={"geometry_type"="POINT", "srid"=3785})
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
     * @ORM\Column(name="typeId", type="integer")
     */
    private $typeId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="changed", type="datetime")
     */
    private $changed;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     */
    private $createdBy;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="changed_by", referencedColumnName="id")
     */
    private $changedBy;


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
     * Set pos
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
     * Get pos
     *
     * @return geometry
     */
    public function getPos()
    {
        return $this->pos;
    }

    /**
     * Set title
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
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
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
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set typeId
     *
     * @param integer $typeId
     *
     * @return DangerPoint
     */
    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;

        return $this;
    }

    /**
     * Get typeId
     *
     * @return int
     */
    public function getTypeId()
    {
        return $this->typeId;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return DangerPoint
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
     * Set changed
     *
     * @param \DateTime $changed
     *
     * @return DangerPoint
     */
    public function setChanged($changed)
    {
        $this->changed = $changed;

        return $this;
    }

    /**
     * Get changed
     *
     * @return \DateTime
     */
    public function getChanged()
    {
        return $this->changed;
    }

    /**
     * Set createdBy
     *
     * @param integer $createdBy
     *
     * @return DangerPoint
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

    /**
     * Set changedBy
     *
     * @param integer $changedBy
     *
     * @return DangerPoint
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
}

