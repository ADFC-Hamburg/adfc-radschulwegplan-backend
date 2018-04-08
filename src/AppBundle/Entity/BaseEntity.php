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

/**
 * BaseEntity.
 */
abstract class BaseEntity
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     *
     * @JMS\Groups({"role-admin", "role-school-admin"})
     */
    protected $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="changed", type="datetime")
     *
     * @JMS\Groups({"role-admin", "role-school-admin"})
     */
    protected $changed;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     *
     * @JMS\Groups({"role-admin", "role-school-admin"})
     */
    protected $createdBy;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="changed_by", referencedColumnName="id")
     *
     * @JMS\Groups({"role-admin", "role-school-admin"})
     */
    protected $changedBy;

    public function __construct()
    {
    }

    /**
     * Set created.
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
     * Get created.
     *
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    /**
     * Set changed.
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
     * Get changed.
     *
     * @return \DateTime
     */
    public function getChanged()
    {
        return $this->changed;
    }

    /**
     * Set createdBy.
     *
     * @param int $createdBy
     *
     * @return BaseEntity
     */
    public function setCreatedBy(User $createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy.
     *
     * @return User
     */
    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    /**
     * Set changedBy.
     *
     * @param int $changedBy
     *
     * @return BaseEntity
     */
    public function setChangedBy(User $changedBy)
    {
        $this->changedBy = $changedBy;

        return $this;
    }

    public function setChangedNow(User $user)
    {
        $this->setChangedBy($user);
        $now = new \DateTime('now');
        $this->setChanged($now);
    }

    public function setCreatedNow(User $user)
    {
        $this->setChangedBy($user);
        $this->setCreatedBy($user);
        $now = new \DateTime('now');
        $this->setChanged($now);
        $this->setCreated($now);
    }

    /**
     * Get changedBy.
     *
     * @return User
     */
    public function getChangedBy(): User
    {
        return $this->changedBy;
    }
}
