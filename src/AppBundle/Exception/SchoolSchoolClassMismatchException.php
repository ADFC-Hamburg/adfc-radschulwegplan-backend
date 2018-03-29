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

namespace AppBundle\Exception;

class SchoolSchoolClassMismatchException extends AppBundleException
{
    /**
     * @param string $path The path to the file that was not found
     */
    public function __construct($schoolId, $schoolIdFromClass)
    {
        parent::__construct(sprintf('SchoolId (%d) doest not match with SchoolId (%d) from SchoolClass', $schoolId, $schoolIdFromClass));
    }
}
