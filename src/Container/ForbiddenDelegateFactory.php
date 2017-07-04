<?php

/**
 * Aist Authorization Middleware (http://mateuszsitek.com/projects/authorization-middleware)
 *
 * @copyright Copyright (c) 2017 DIGITAL WOLVES LTD (http://digitalwolves.ltd) All rights reserved.
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace Aist\AuthorizationMiddleware\Container;

use Aist\AuthorizationMiddleware\Delegate\ForbiddenDelegate;
use Psr\Container\ContainerInterface;
use Zend\Diactoros\Response;
use Zend\Expressive\Template\TemplateRendererInterface;

class ForbiddenDelegateFactory
{
    /**
     * @param ContainerInterface $container
     * @return ForbiddenDelegate
     */
    public function __invoke(ContainerInterface $container)
    {
        $config   = $container->has('config') ? $container->get('config') : [];
        $renderer = $container->has(TemplateRendererInterface::class)
            ? $container->get(TemplateRendererInterface::class)
            : null;
        $template = isset($config['zend-expressive']['error_handler']['template_403'])
            ? $config['zend-expressive']['error_handler']['template_403']
            : ForbiddenDelegate::TEMPLATE_DEFAULT;

        return new ForbiddenDelegate(new Response(), $renderer, $template);
    }
}
