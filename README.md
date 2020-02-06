Lamoda Tactician Locking Middleware
=================================

[![Build Status](https://travis-ci.org/lamoda/tactician-locking-middleware.svg?branch=master)](https://travis-ci.org/lamoda/tactician-locking-middleware)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/lamoda/tactician-locking-middleware/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/lamoda/tactician-locking-middleware/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/lamoda/tactician-locking-middleware/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/lamoda/tactician-locking-middleware/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/lamoda/tactician-locking-middleware/badges/build.png?b=master)](https://scrutinizer-ci.com/g/lamoda/tactician-locking-middleware/build-status/master)
![test](https://github.com/lamoda/tactician-locking-middleware/workflows/test/badge.svg)

Updated version of core [Locking Middleware](https://tactician.thephpleague.com/plugins/locking-middleware/) plugin. Can handle \Throwable, not only \Exception.

## Installation

### Composer

```sh
composer require lamoda/tactician-locking-middleware
```

### Configuration

```php
use Lamoda\TacticianLockingMiddleware\LockingMiddleware;
use League\Tactician\CommandBus;

$lockingMiddleware = new LockingMiddleware();

$commandBus = new CommandBus([
    $lockingMiddleware,
    // ... your other middleware...
]);
```
