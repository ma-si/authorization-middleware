<?php

/**
 * Aist Authorization Middleware (http://mateuszsitek.com/projects/authorization-middleware)
 *
 * @copyright Copyright (c) 2017 DIGITAL WOLVES LTD (http://digitalwolves.ltd) All rights reserved.
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace AistTest\AuthorizationMiddleware;

use Aist\AuthorizationMiddleware\Delegate\UnauthorizedDelegate;
use Aist\AuthorizationMiddleware\Middleware\UnauthorizedHandler;
use Interop\Container\ContainerInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Router\RouterInterface;

class UnauthorizedHandlerTest extends TestCase
{
    /** @var UnauthorizedDelegate|ObjectProphecy */
    private $internalDelegate;

    /** @var ServerRequestInterface|ObjectProphecy */
    private $request;

    /** @var DelegateInterface|ObjectProphecy */
    private $delegate;

    public function setUp()
    {
        $this->internalDelegate = $this->prophesize(UnauthorizedDelegate::class);
        $this->request  = $this->prophesize(ServerRequestInterface::class);
        $this->delegate = $this->prophesize(DelegateInterface::class);
    }

    public function testImplementsInteropMiddleware()
    {
        $handler = new UnauthorizedHandler($this->internalDelegate->reveal());
        $this->assertInstanceOf(MiddlewareInterface::class, $handler);
    }

    public function testInvokesInternalDelegateIfRequestDoesNotContainIdentity()
    {
        $this->request->getAttribute('identity', false)->willReturn(false);
        $this->delegate->process(Argument::type(ServerRequestInterface::class))->shouldNotBeCalled();

        $this->internalDelegate->process(Argument::that([$this->request, 'reveal']))->willReturn('CONTENT');
        $handler = new UnauthorizedHandler($this->internalDelegate->reveal());
        $this->assertEquals('CONTENT', $handler->process($this->request->reveal(), $this->delegate->reveal()));
    }
}
