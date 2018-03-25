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

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ));
    }
}
