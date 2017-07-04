<?php

/**
 * Aist Authorization Middleware (http://mateuszsitek.com/projects/authorization-middleware)
 *
 * @copyright Copyright (c) 2017 DIGITAL WOLVES LTD (http://digitalwolves.ltd) All rights reserved.
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace Aist\AuthorizationMiddleware;

use Aist\AuthorizationMiddleware\Container\ForbiddenDelegateFactory;
use Aist\AuthorizationMiddleware\Container\UnauthorizedDelegateFactory;
use Aist\AuthorizationMiddleware\Container\UnauthorizedHandlerFactory;
use Aist\AuthorizationMiddleware\Delegate\ForbiddenDelegate;
use Aist\AuthorizationMiddleware\Delegate\UnauthorizedDelegate;
use Aist\AuthorizationMiddleware\Middleware\AuthorizationMiddleware;
use Aist\AuthorizationMiddleware\Middleware\AuthorizationMiddlewareFactory;
use Aist\AuthorizationMiddleware\Middleware\UnauthorizedHandler;

/**
 * The configuration provider for the Auth module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    public function getDependencies()
    {
        return [
            'factories' => [
                AuthorizationMiddleware::class => AuthorizationMiddlewareFactory::class,
                UnauthorizedHandler::class => UnauthorizedHandlerFactory::class,
                UnauthorizedDelegate::class => UnauthorizedDelegateFactory::class,
                ForbiddenDelegate::class => ForbiddenDelegateFactory::class,
            ],
        ];
    }
}
