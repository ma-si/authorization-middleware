# Aist Authorization Middleware [![SensioLabsInsight](https://insight.sensiolabs.com/projects/e93aca3a-bcca-4029-80ce-e873b7de9b6b/small.png)](https://insight.sensiolabs.com/projects/e93aca3a-bcca-4029-80ce-e873b7de9b6b)

[![Build status][Master image]][Master]
[![Coverage Status][Master coverage image]][Master coverage]
[![Code Climate][Code Climate image]][Code Climate]
[![Sensio][SensioLabsInsight image]][SensioLabsInsight]
[![Packagist][Packagist image]][Packagist]

[![License][License image]][License]

*PSR-7 Authorization Middleware.*

## Installation

Install via composer:

```console
$ composer require aist/authorization-middleware
```

## Configuration

Add pipe to protect whole app
```
// Add more middleware here that needs to introspect the routing results; this
// might include:
//
// - route-based authentication
// - route-based validation
// - etc.

// Authentication middleware
$app->pipe(\Aist\AuthenticationMiddleware\Middleware\AuthenticationMiddleware::class);

// Authorization middleware
// At this point, if no identity is set by authorization middleware, the
// UnauthorizedHandler kicks in; alternately, you can provide other fallback
// middleware to execute.
//$app->pipe(\Aist\AuthorizationMiddleware\Middleware\UnauthorizedHandler::class);
// Authorization
$app->pipe(\Aist\AuthorizationMiddleware\Middleware\AuthorizationMiddleware::class);
```
or use for specific route
```
$app->get(
    '/',
    [
        \Aist\AuthenticationMiddleware\Middleware\AuthenticationMiddleware::class,
        \Aist\AuthorizationMiddleware\Middleware\AuthorizationMiddleware::class,
        App\Action\DashboardAction::class,
    ],
    'dashboard'
);
```

  [Master image]: https://img.shields.io/travis/ma-si/authorization-middleware/master.svg?style=flat-square
  [Master]: https://secure.travis-ci.org/ma-si/authorization-middleware
  [Master coverage image]: https://img.shields.io/coveralls/ma-si/authorization-middleware/master.svg?style=flat-square
  [Master coverage]: https://coveralls.io/r/ma-si/authorization-middleware?branch=master
  [Code Climate image]: https://img.shields.io/codeclimate/github/ma-si/authorization-middleware.svg?style=flat-square
  [Code Climate]: https://codeclimate.com/github/ma-si/authorization-middleware
  [SensioLabsInsight image]: https://img.shields.io/sensiolabs/i/e93aca3a-bcca-4029-80ce-e873b7de9b6b.svg?style=flat-square
  [SensioLabsInsight]: https://insight.sensiolabs.com/projects/e93aca3a-bcca-4029-80ce-e873b7de9b6b
  [Packagist image]: https://img.shields.io/packagist/v/aist/authorization-middleware.svg?style=flat-square
  [Packagist]: https://packagist.org/packages/aist/authorization-middleware
  [License image]: https://poser.pugx.org/aist/authorization-middleware/license?format=flat-square
  [License]: https://opensource.org/licenses/BSD-3-Clause
