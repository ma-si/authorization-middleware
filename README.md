# Aist Authorization Middleware [![SensioLabsInsight](https://insight.sensiolabs.com/projects/e93aca3a-bcca-4029-80ce-e873b7de9b6b/small.png)](https://insight.sensiolabs.com/projects/e93aca3a-bcca-4029-80ce-e873b7de9b6b)

Master:
[![Build status][Master image]][Master]
[![Coverage Status][Master coverage image]][Master coverage]
Develop:
[![Build status][Develop image]][Develop]
[![Coverage Status][Develop coverage image]][Develop coverage]

[![Packagist][Packagist image]][Packagist]
[![Code Climate][Code Climate image]][Code Climate]

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

  [Master]: https://secure.travis-ci.org/ma-si/authorization-middleware
  [Master image]: https://secure.travis-ci.org/ma-si/authorization-middleware.svg?branch=master
  [Master coverage image]: https://img.shields.io/coveralls/ma-si/authorization-middleware/master.svg
  [Master coverage]: https://coveralls.io/r/ma-si/authorization-middleware?branch=master
  [Develop]: https://github.com/ma-si/authorization-middleware/tree/develop
  [Develop image]:  https://secure.travis-ci.org/ma-si/authorization-middleware.svg?branch=develop
  [Develop coverage image]: https://coveralls.io/repos/ma-si/authorization-middleware/badge.svg?branch=develop
  [Develop coverage]: https://coveralls.io/r/ma-si/authorization-middleware?branch=develop
  [Packagist image]: https://img.shields.io/packagist/v/aist/authorization-middleware.svg
  [Packagist]: https://img.shields.io/packagist/v/aist/authorization-middleware.svg
  [Code Climate image]: https://codeclimate.com/github/ma-si/authorization-middleware/badges/gpa.svg
  [Code Climate]: https://codeclimate.com/github/ma-si/authorization-middleware
  [License image]: https://poser.pugx.org/aist/authorization-middleware/license
  [License]: https://packagist.org/packages/aist/authorization-middleware
