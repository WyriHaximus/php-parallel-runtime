# ext-parallel Runtime Wrapper

`ext-parallel` runtime wrapping adding error, signal, and exception handling.

![Continuous Integration](https://github.com/wyrihaximus/php-parallel-runtime/workflows/Continuous%20Integration/badge.svg)
[![Latest Stable Version](https://poser.pugx.org/wyrihaximus/parallel-runtime/v/stable.png)](https://packagist.org/packages/wyrihaximus/parallel-runtime)
[![Total Downloads](https://poser.pugx.org/wyrihaximus/parallel-runtime/downloads.png)](https://packagist.org/packages/wyrihaximus/parallel-runtime/stats)
[![Code Coverage](https://coveralls.io/repos/github/WyriHaximus/php-parallel-runtime/badge.svg?branchmaster)](https://coveralls.io/github/WyriHaximus/php-parallel-runtime?branch=master)
[![Type Coverage](https://shepherd.dev/github/WyriHaximus/php-parallel-runtime/coverage.svg)](https://shepherd.dev/github/WyriHaximus/php-parallel-runtime)
[![License](https://poser.pugx.org/wyrihaximus/parallel-runtime/license.png)](https://packagist.org/packages/wyrihaximus/parallel-runtime)

# Installation

To install via [Composer](http://getcomposer.org/), use the command below, it will automatically detect the latest version and bind it with `^`.

```
composer require wyrihaximus/parallel-runtime
```

# Usage

The `Runtime` class transparently wraps `ext-parallel`'s runtime class. But instead of what you return from your
closure it will return an `Outcome` object. The `Outcome` object containers the results of your closure, but also any
reported errors. Consider the following example:

```php
<?php

declare(strict_types=1);

use WyriHaximus\Parallel\Runtime;

use function trigger_error;

use const WyriHaximus\Constants\ComposerAutoloader\LOCATION;

$runtime = new Runtime(LOCATION);
$future  = $runtime->run(static function (): string {
    trigger_error('Error! Error! Error!');

    return 'yay';
});
$outcome = $future->value();
echo get_class($outcome), PHP_EOL; // WyriHaximus\Parallel\Outcome
echo $outcome->result(), PHP_EOL; // yay
foreach ($outcome->errors() as $error) {
    echo $error[1], PHP_EOL; // Error! Error! Error!
}
```

# License

The MIT License (MIT)

Copyright (c) 2020 Cees-Jan Kiewiet

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
