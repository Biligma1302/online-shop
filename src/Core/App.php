<?php

declare(strict_types=1);

namespace Core;

use Service\Logger\LoggerServiceFile;
use Service\Logger\LoggerServiceBd;

use Throwable;

class App
{
    private array $routes = [];

    public function run(): void
    {
        $requestUri = explode('?', $_SERVER['REQUEST_URI'])[0];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if (isset($this->routes[$requestUri])) {
            $routeMethods = $this->routes[$requestUri];
            if (isset($routeMethods[$requestMethod])) {
                $handler = $routeMethods[$requestMethod];
                $class = $handler['class'];
                $method = $handler['method'];

                $controller = new $class();

                $requestClass = $handler['request'];

                $logger = LoggerServiceFile::class;

                try {
                    if ($requestClass !== null) {
                        $request = new $requestClass($_POST);
                        $controller->$method($request);
                    } else {
                        $controller->$method();
                    }
                } catch (Throwable $exception) {
                    $logger::error($exception);

                    require_once '../Views/500.php';
                }
            } else {
                echo "$requestMethod не поддерживается для $requestUri";
            }
        } else {
            http_response_code(404);
            require_once '../Views/404.php';
        }
    }


    public function get(string $route, string $className, string $method, ?string $requestClass = null): void
    {
        $this->routes[$route]['GET'] = [
            'class' => $className,
            'method' => $method,
            'request' => $requestClass
        ];
    }

    public function post(string $route, string $className, string $method, ?string $requestClass = null): void
    {
        $this->routes[$route]['POST'] = [
            'class' => $className,
            'method' => $method,
            'request' => $requestClass
        ];
    }

    public function put(string $route, string $className, string $method): void
    {
        $this->routes[$route]['PUT'] = [
            'class' => $className,
            'method' => $method
        ];
    }

    public function delete(string $route, string $className, string $method): void
    {
        $this->routes[$route]['DELETE'] = [
            'class' => $className,
            'method' => $method
        ];
    }
}