# BEAR.Sunday Thrift

A package that allows high-speed access to BEAR.Sunday resources from multiple languages using [Thrift](https://thrift.apache.org/) and [Swoole](https://www.swoole.co.uk/).

## Features
 * BEAR.Sunday resources can be used as assets
 * Access resources regardless of language (currently supports Go and Python)
* Fast access with Thrift/Swoole
* Can call resources from older versions of BEAR.Sunday projects
* Operates in coordination without an HTTP server

## Why BEAR.Sunday Thrift?

BEAR.Sunday is characterized by its clean, resource-oriented architecture.

 * Resources are application assets
 * Improve performance with fast resource access
 * Accelerate development by utilizing resources in other languages
 * Integrate legacy projects with the latest BEAR.Sunday
 * Loosely couple multiple applications without HTTP

Because it is resource-oriented, BEAR.Sunday's resources become assets and can continue to be utilized even when migrating to other languages or frameworks.

## Installation

```
composer require bearsunday/thrift
```

## Usage

### Server-side (PHP:BEAR.Sunday)

```php
$config = new Config(
    appName: 'MyVendor\MyApp',
    hostname: '127.0.0.1',
    port: 9090,
    appDir: dirname(__DIR__) . '/tests/Fake/app',
    context: 'prod-app',
    server: Engine::Swoole
);
$server = new Server($config);
$server->echoStartMessage();
$server->start();
```

```shell
> php bin/serve.php
[Sun Mar 17 19:39:20 2024] PHP 8.3.4 Thrift Server (powered by Swoole) started.
Listening on http://127.0.0.1:9090
Document root is /path/to/app
Application context is prod-hal-api-app
```

## Client-side

### Go

```go
    response, err := ResourceInvoke(hostname, port, method, path, query)
    if err != nil {
        fmt.Println("Error:", err)
        return
    }
    fmt.Println("Response Code:", response.Code)
    fmt.Println("Response Headers:", response.Headers)
    fmt.Println("Raw Response JsonValue: ", response.JsonValue)
    fmt.Println("Response View:", response.View)
```

### Python

```python
    response = ResourceInvoke(hostname, port, method, path, query)
    if not response:
        print("Request failed.")
        return

    print("Response Code:", response.code)
    print("Response Headers:", response.headers)
    print("Raw Response JsonValue:", response.jsonValue)
    print("Response View:", response.view)
```

As you can see, it's easy to access BEAR.Sunday resources from other languages.
**Resources become assets that transcend applications** and can be accessed quickly.
