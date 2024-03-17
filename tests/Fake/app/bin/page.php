<?php

declare(strict_types=1);

use MyVendor\MyApp\Bootstrap;

require dirname(__DIR__) . '/autoload.php';
exit((new Bootstrap())(PHP_SAPI === 'cli' ? 'prod-cli-hal-app' : 'hal-app', $GLOBALS, $_SERVER));
