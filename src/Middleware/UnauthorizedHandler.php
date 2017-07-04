<?php

/**
 * Aist Authorization Middleware (http://mateuszsitek.com/projects/authorization-middleware)
 *
 * @copyright Copyright (c) 2017 DIGITAL WOLVES LTD (http://digitalwolves.ltd) All rights reserved.
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace Aist\AuthorizationMiddleware\Middleware;

use Aist\AuthorizationMiddleware\Delegate\UnauthorizedDelegate;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UnauthorizedHandler implements MiddlewareInterface
{
    /**
     * @var UnauthorizedDelegate
     */
    private $internalDelegate;

    /**
     * @param UnauthorizedDelegate $internalDelegate
     */
    public function __construct(UnauthorizedDelegate $internalDelegate)
    {
        $this->internalDelegate = $internalDelegate;
    }

    /**
     * Creates and returns a 401 response.
     *
     * @param ServerRequestInterface $request Passed to internal delegate
     * @param DelegateInterface $delegate Ignored.
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $identity = $request->getAttribute('identity', false);

        if (false === $identity) {
            return $this->internalDelegate->process($request);
        }

        return $delegate->process($request);
    }
}
