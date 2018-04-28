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
 * DangerType.
 *
 * @ORM\Table(name="danger_type")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DangerTypeRepository")
 */
class DangerType
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=60)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="icon", type="string", length=30)
     */
    private $icon;

    public function __construct()
    {
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get Icon.
     *
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * Set Id.
     *
     * @param int $id
     *
     * @return DangerType
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return DangerType
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set icon.
     *
     * @param string $icon
     *
     * @return DangerType
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }
}
