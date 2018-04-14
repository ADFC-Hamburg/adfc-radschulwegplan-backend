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

use AppBundle\Entity\SchoolClass;

/**
 * SchoolClassRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SchoolClassRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Return only schoolClass from a specific school.
     *
     * @param int $id SchoolId
     *
     * @return SchoolClass[]
     */
    public function findAllFromSchool(int $id)
    {
        return $this->getEntityManager()
                    ->createQuery('SELECT c FROM AppBundle:SchoolClass c  WHERE c.school = :sId ORDER BY c.id')
                    ->setParameter('sId', $id)
                    ->getResult();
    }
}
