<?php

/**
 * Aist Authorization Middleware (http://mateuszsitek.com/projects/authorization-middleware)
 *
 * @copyright Copyright (c) 2017 DIGITAL WOLVES LTD (http://digitalwolves.ltd) All rights reserved.
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace Aist\AuthorizationMiddleware\Middleware;

use Aist\AuthorizationMiddleware\Delegate\ForbiddenDelegate;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Router\RouteResult;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Permissions\Rbac\AssertionInterface;
use Zend\Permissions\Rbac\Rbac;

class AuthorizationMiddleware implements MiddlewareInterface
{
    private $rbac;
    private $template;

    private $forbiddenDelegate;

    public function __construct(Rbac $rbac, TemplateRendererInterface $template, ForbiddenDelegate $forbiddenDelegate)
    {
        $this->rbac        = $rbac;
        $this->template    = $template;
        $this->forbiddenDelegate = $forbiddenDelegate;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $identity = $request->getAttribute('identity', false);

        /**
         * Assign default role for unauthenticated
         */
        if (! $identity) {
            $identity = [
                'role' => 'guest',
                'user' => 'guest',
            ];
        }

        $route = $request->getAttribute(RouteResult::class);
        if (! $route) {
            // no route matched - process to 404
            return $delegate->process($request);
        }
        $routeName = $route->getMatchedRoute()->getName();

        if (! $this->rbac->isGranted($identity['role'], $routeName, $assert ?? null)) {
            return $this->forbiddenDelegate->process($request);
        }
        $request = $request->withAttribute('rbac', $this->rbac);

        return $delegate->process($request);
    }
}
