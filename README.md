# BEAR.Sunday Thrift

[![CI](https://github.com/bearsunday/BEAR.Thrift/actions/workflows/main.yml/badge.svg)](https://github.com/bearsunday/BEAR.Thrift/actions/workflows/main.yml)

A package that allows high-speed access to BEAR.Sunday resources from multiple languages using [Thrift](https://thrift.apache.org/) and [Swoole](https://www.php.net/manual/en/book.swoole.php).

## Features

* BEAR.Sunday resources can be utilized across various languages and frameworks
* Seamless access to remote BEAR.Sunday apps from the local BEAR.Sunday app
* Access resources regardless of language (currently supports PHP, Go, Python, Ruby and BEAR.Sunday)
* Fast access with Thrift/Swoole, compared to HTTP
* Can call resources from older versions of BEAR.Sunday apps
* Operates independently of an HTTP server

## Installation

```
composer require bearsunday/thrift
```

## Usage

### Server-side (PHP:BEAR.Sunday)

bin/serve.php

```php
(new ServerBootstrap)(new Config(
    appName: 'MyVendor\MyApp',
    hostname: '127.0.0.1',
    port: 9090,
    appDir: dirname(__DIR__) . '/path/to/app',
    context: 'prod-app',
    server: Engine::Swoole
))
```

Start Thrift server

```shell
> php bin/serve.php
[Sun Mar 17 19:39:20 2024] PHP 8.3.4 Thrift Server (powered by Swoole) started.
Listening on http://127.0.0.1:9090
Document root is /path/to/app
Application context is prod-hal-api-app
```

## Client-side

### BEAR.Sunday

Import Thrift App in the module.
```php
    protected function configure(): void
    {
        // Binding thirft app to a host called "sekai"
        $this->override(new ImportThriftAppModule([
            new ThriftApp('sekai', '127.0.0.1', '9090')
        ]));
    }
```

Thrift apps available just like the 'self' app. See [more](/client/bear_client/main.php).
```php
echo $resource->get('page://self/?name=Sekai');  // "greeting": "Konichiwa Sekai" from local app
echo $resource->get('page://sekai/?name=World'); // "greeting": "Hello World" from remote(127.0.0.1:9090) app
// echo $resource->get('/?name=World'); // "greeting": "Hello World" from remote(127.0.0.1:9090) app
```


### PHP

```php
    $invoker = new ResourceInvoker($host, $port);
    $method = 'get';
    $uri = '/user?id=1';
    $response = $invoker->resourceInvoke($method, $uri);
    assert($response instanceof ResourceResponse);
    printf("Response Code: %s\n", $response->code);
    printf("Response Headers: %s\n", json_encode($response->headers));
    printf("Raw Response JsonValue: : %s\n", $response->jsonValue);
    printf("Response View: %s\n", $response->view);
```

### Go

```go
    method := "get"
    uri := "/user?id=1
    response, err := ResourceInvoke(hostname, port, method, uri)
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
    method = "get"
    uri = "/user?id=1"
    response = ResourceInvoke(hostname, port, method, uri)
    if not response:
        print("Request failed.")
        return

    print("Response Code:", response.code)
    print("Response Headers:", response.headers)
    print("Raw Response JsonValue:", response.jsonValue)
    print("Response View:", response.view)
```

### Ruby

```Ruby
method = "get"
uri = "/user?id=1"

resource_invoke = ResourceInvoke.new(hostname, port)
response = resource_invoke.call(method, uri)

puts "Response Code: #{response.code}"
puts "Response Headers: #{response.headers}"
puts "Raw Response JsonValue: #{response.jsonValue}"
puts "Response View: #{response.view}"
```

Note: The URI can be a schema as well as a path. Instead of `/user?id=1`, you can specify `page://self/user?id=1` to access both app and page resources.

As you can see, it's easy to access BEAR.Sunday resources from other languages.
**Resources become assets that transcend applications** and can be accessed quickly.


## Demo

Build go & python and start the thrift server.

```
composer build:all
composer serve
```

Run the go and pythonclient with another terminal.

```
composer run:go
composer run:py
composer run:php
```

Note: Swoole, Thrift, go and python must be installed to run the above scripts. Straight forward if you're installing with brew.

```
brew install thrift
brew install go
brew install python3
```
