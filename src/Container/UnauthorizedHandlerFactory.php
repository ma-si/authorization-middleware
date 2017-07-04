<?php

/**
 * Aist Authorization Middleware (http://mateuszsitek.com/projects/authorization-middleware)
 *
 * @copyright Copyright (c) 2017 DIGITAL WOLVES LTD (http://digitalwolves.ltd) All rights reserved.
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace Aist\AuthorizationMiddleware\Container;

use Aist\AuthorizationMiddleware\Delegate\UnauthorizedDelegate;
use Aist\AuthorizationMiddleware\Middleware\UnauthorizedHandler;
use Psr\Container\ContainerInterface;

class UnauthorizedHandlerFactory
{
    /**
     * @param ContainerInterface $container
     * @return UnauthorizedHandler
     */
    public function __invoke(ContainerInterface $container)
    {
        return new UnauthorizedHandler($container->get(UnauthorizedDelegate::class));
    }
}
