<?php

namespace AppBundle\Exception;


class SchoolSchoolClassMismatchException extends AppBundleException
{
    /**
     * @param string $path The path to the file that was not found
     */
    public function __construct($schoolId, $schholIdFromClass)
    {
        parent::__construct(sprintf('SchoolId (%d) doest not match with SchoolId (%d) from SchoolClass', $schoolId, $schoolIdFromClass));
    }
}
