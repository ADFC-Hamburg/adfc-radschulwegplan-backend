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

namespace AppBundle\EventListener;

use FOS\RestBundle\FOSRestBundle;
use FOS\RestBundle\View\View;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class ADFCResponseListener implements EventSubscriberInterface
{
    /**
     * @var LoggerInterface Logger to save log messages
     */
    private $logger;

    /**
     * @var AuthorizationCheckerInterface Auth Checker, check roles
     */
    private $authorizationChecker;

    public function __construct(LoggerInterface $logger,
        AuthorizationCheckerInterface $authorizationChecker
    ) {
        $this->logger = $logger;
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * Renders the parameters and template and initializes a new response object with the
     * rendered content.
     *
     * @param GetResponseForControllerResultEvent $event
     */
    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        $request = $event->getRequest();

        if (!$request->attributes->get(FOSRestBundle::ZONE_ATTRIBUTE, true)) {
            return false;
        }

        $view = $event->getControllerResult();
        if (!$view instanceof View) {
            $view = new View($view);
        }
        $context = $view->getContext();
        $path = str_replace('/api/v1/', '', $request->getPathInfo());
        $path = preg_split("/\//", $path);

        $groups = array('any', 'path-'.$path[0].'-any');
        if (count($path) > 1) {
            $groups[] = 'path-'.$path[0].'-'.$path[1].'-any';
        }
        $roles = array('ROLE_ADMIN', 'ROLE_SCHOOL_ADMIN', 'ROLE_SCHOOL_REVIEW', 'ROLE_STUDENT');

        foreach ($roles as $role) {
            if ($this->authorizationChecker->isGranted($role)) {
                $baserole = strtolower(str_replace('ROLE_', '', $role));
                $baserole = strtolower(str_replace('_', '-', $baserole));
                $groups[] = 'path-'.$path[0].'-'.$baserole;
                if (count($path) > 1) {
                    $groups[] = 'path-'.$path[0].'-'.$path[1].'-'.$baserole;
                }
                $groups[] = 'role-'.$baserole;
            }
        }
        $this->logger->debug('role-based-serializerGroups', $groups);

        $context->setGroups($groups);
        $context->enableMaxDepth();
        $view->setContext($context);
        $event->setControllerResult($view);
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        // Must be executed before SensioFrameworkExtraBundle's listener
        return array(
            KernelEvents::VIEW => array('onKernelView', 31),
        );
    }
}
