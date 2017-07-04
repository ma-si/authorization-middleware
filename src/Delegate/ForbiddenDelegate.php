<?php

/**
 * Aist Authorization Middleware (http://mateuszsitek.com/projects/authorization-middleware)
 *
 * @copyright Copyright (c) 2017 DIGITAL WOLVES LTD (http://digitalwolves.ltd) All rights reserved.
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace Aist\AuthorizationMiddleware\Delegate;

use Fig\Http\Message\StatusCodeInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Router\RouteResult;
use Zend\Expressive\Template\TemplateRendererInterface;

class ForbiddenDelegate implements DelegateInterface
{
    const TEMPLATE_DEFAULT = 'error::403';

    const PHRASE = 'Forbidden';

    const STATUS = StatusCodeInterface::STATUS_FORBIDDEN;

    /**
     * @var TemplateRendererInterface
     */
    private $renderer;

    /**
     * This duplicates the property in StratigilityNotFoundHandler, but is done
     * to ensure that we have access to the value in the methods we override.
     *
     * @var ResponseInterface
     */
    protected $responsePrototype;

    /**
     * @var string
     */
    private $template;

    /**
     * @param ResponseInterface $responsePrototype
     * @param TemplateRendererInterface $renderer
     * @param string $template
     */
    public function __construct(
        ResponseInterface $responsePrototype,
        TemplateRendererInterface $renderer = null,
        $template = self::TEMPLATE_DEFAULT
    ) {

        $this->responsePrototype = $responsePrototype;
        $this->renderer = $renderer;
        $this->template = $template;
    }

    /**
     * Creates and returns a self::STATUS response.
     *
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request)
    {
        if (! $this->renderer) {
            return $this->generatePlainTextResponse($request);
        }

        return $this->generateTemplatedResponse($request);
    }

    /**
     * Generates a plain text response indicating the request method and URI.
     *
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    private function generatePlainTextResponse(ServerRequestInterface $request)
    {
        $response = $this->responsePrototype->withStatus(self::STATUS);
        $response->getBody()->write(self::PHRASE);

        return $response;
    }

    /**
     * Generates a response using a template.
     *
     * Template will receive the current request via the "request" variable.
     *
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    private function generateTemplatedResponse(ServerRequestInterface $request)
    {
        $identity = $request->getAttribute('identity', false);
        $route = $request->getAttribute(RouteResult::class, false);
        if (false === $route) {
            // no route - process to 404
        }
        $matchedRoute = $route->getMatchedRoute();
        if (false === $matchedRoute) {
            // no route matched - process to 404
        }
        $resource = $matchedRoute->getName();

        $response = $this->responsePrototype->withStatus(self::STATUS);
        $response->getBody()->write(
            $this->renderer->render(
                $this->template,
                [
                    'identity' => $identity,
                    'resource' => $resource,
                    'status' => self::STATUS,
                    'reason' => self::PHRASE,
                ]
            )
        );

        return $response;
    }
}
