<?php

declare(strict_types=1);

namespace BEARSunday\Thrift;

use BEAR\Package\Injector;
use BEAR\Sunday\Extension\Application\AppInterface;

use function date;
use function printf;

use const PHP_VERSION;

/**
 * The Bootstrap class is responsible for starting the Thrift server.
 */
final class Server
{
    public function __construct(private ServerConfig $config)
    {
    }

    public function echoStartMessage(): void
    {
        printf(
            "[%s] PHP %s Thrift Server (powered by %s) started.\nListening on http://%s:%s\nDocument root is %s\nApplication context is %s\n",
            date('D M j H:i:s Y'),
            PHP_VERSION,
            $this->config->engine->name,
            $this->config->thriftHost,
            $this->config->thriftPort,
            $this->config->appDir,
            $this->config->context,
        );
    }

    public function start(): void
    {
        $injector = Injector::getInstance($this->config->appName, $this->config->context, $this->config->appDir);
        $app = $injector->getInstance(AppInterface::class);
        $thriftServer = $this->config->engine === Engine::Php ? new PhpServer() : new SwooleServer();
        $thriftServer->start($app->resource, $this->config->thriftHost, $this->config->thriftPort);
    }
}
