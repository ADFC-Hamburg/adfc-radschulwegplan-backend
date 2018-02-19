<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BaseEntity
 *
 */
abstract class BaseEntity
{

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    protected $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="changed", type="datetime")
     */
    protected $changed;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     */
    protected $createdBy;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="changed_by", referencedColumnName="id")
     */
    protected $changedBy;


    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return BaseEntity
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated():DateTime
    {
        return $this->created;
    }

    /**
     * Set changed
     *
     * @param \DateTime $changed
     *
     * @return BaseEntity
     */
    public function setChanged(\DateTime $changed)
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
     * @return BaseEntity
     */
    public function setCreatedBy(User $createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return User
     */
    public function getCreatedBy():User
    {
        return $this->createdBy;
    }

    /**
     * Set changedBy
     *
     * @param integer $changedBy
     *
     * @return BaseEntity
     */
    public function setChangedBy(User $changedBy)
    {
        $this->changedBy = $changedBy;

        return $this;
    }
    public function setChangedNow(User $user) {
        $this->setChangedBy($user);
        $now=new \DateTime("now");
        $this->setChanged($now);
    }
    public function setCreatedNow(User $user) {
        $this->setChangedBy($user);
        $this->setCreatedBy($user);
        $now=new \DateTime("now");
        $this->setChanged($now);
        $this->setCreated($now);
    }
    /**
     * Get changedBy
     *
     * @return User
     */
    public function getChangedBy():User
    {
        return $this->changedBy;
    }
}

