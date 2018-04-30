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

namespace AppBundle\Repository;

use AppBundle\Entity\DangerType;

/**
 * DangerPointRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DangerTypeRepository extends \Doctrine\ORM\EntityRepository
{
    const ITEMS = array(
        array('id' => 1, 'icon' => 'fa-angle-down', 'name' => 'Belag ist schlecht oder uneben.'),
        array('id' => 2, 'icon' => 'fa-level-down-alt', 'name' => 'Bordsteinabsenkung ist ungenügend.'),
        array('id' => 3, 'icon' => 'fa-exchange-alt', 'name' => 'Radwegauf- bzw. abfahrt ist schlecht oder nicht vorhanden.'),
        array('id' => 4, 'icon' => 'fa-hourglas', 'name' => 'Ampelschaltung ist schlecht.'),
        array('id' => 5, 'icon' => 'fa-exclamation', 'name' => 'Unübersichtliche Stelle'),
        array('id' => 6, 'icon' => 'fa-ambulance', 'name' => 'Autofahrer - Radfahrer Konflikt.'),
        array('id' => 7, 'icon' => 'fa-male', 'name' => 'Fußgänger - Radfahrer Konflikt '),
        array('id' => 8, 'icon' => 'fa-map-signs', 'name' => 'Hindernisse wie Laternen, Poller, Plakate'),
        array('id' => 9, 'icon' => 'fa-car', 'name' => 'Parkende Autos sind (regelmäßig) im Weg.'),
        array('id' => 10, 'icon' => 'fa-lightbulb', 'name' => 'Beleuchtung fehlt bzw. ist unzureichend.'),
        array('id' => 11, 'icon' => 'fa-bicycle', 'name' => 'Radwegverbindung fehlt bzw. ist unzureichend.'),
        array('id' => 12, 'icon' => 'fa-eye', 'name' => 'Radkennzeichen - Markierung fehlt bzw. ist unzureichend.'),
        array('id' => 13, 'icon' => 'fa-ban', 'name' => 'Gehwegbenutzung'),
        array('id' => 14, 'icon' => 'fa-question-circle', 'name' => 'Sonstiges'),
        );

    /**
     * Insert all DangerTypes.
     */
    public function insertDangerTypes()
    {
        $em = $this->getEntityManager();
        $arr = array();
        foreach (self::ITEMS as $data) {
            $type = new DangerType();
            $type->setId($data['id']);
            $type->setName($data['name']);
            $type->setIcon($data['icon']);
            $em->persist($type);
            $arr[] = $type;
        }
        $em->flush();

        return $arr;
    }
}