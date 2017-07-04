<?php

/**
 * Aist Authorization Middleware (http://mateuszsitek.com/projects/authorization-middleware)
 *
 * @copyright Copyright (c) 2017 DIGITAL WOLVES LTD (http://digitalwolves.ltd) All rights reserved.
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace Aist\AuthorizationMiddleware\Middleware;

use Aist\AuthorizationMiddleware\Delegate\ForbiddenDelegate;
use Exception;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Permissions\Rbac\Rbac;
use Zend\Permissions\Rbac\Role;

class AuthorizationMiddlewareFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');
        if (! isset($config['rbac']['roles'])) {
            throw new Exception('Rbac roles are not configured');
        }
        if (! isset($config['rbac']['permissions'])) {
            throw new Exception('Rbac permissions are not configured');
        }

        $rbac = new Rbac();
        $rbac->setCreateMissingRoles(true);

        // roles and parents
        foreach ($config['rbac']['roles'] as $role => $parents) {
            $rbac->addRole($role, $parents);
        }

        // permissions
        foreach ($config['rbac']['permissions'] as $role => $permissions) {
            foreach ($permissions as $perm) {
                $rbac->getRole($role)->addPermission($perm);
            }
        }

        return new AuthorizationMiddleware(
            $rbac,
            $container->get(TemplateRendererInterface::class),
            $container->get(ForbiddenDelegate::class)
        );
    }
}
