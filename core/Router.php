<?php

class Router
{
    private $routes = [];
    private $basePath;

    public function __construct($basePath = '')
    {
        $this->basePath = trim($basePath, '/');
    }

    public function get($uri, $controller)
    {
        $this->addRoute('GET', $uri, $controller);
    }

    public function post($uri, $controller)
    {
        $this->addRoute('POST', $uri, $controller);
    }

    private function addRoute($method, $uri, $controller)
    {
        $this->routes[] = ['method' => $method, 'uri' => $uri, 'controller' => $controller];
    }

    public function dispatch()
    {
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        if ($this->basePath) {
            $uri = str_replace($this->basePath, '', $uri);
            $uri = trim($uri, '/');
        }
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            if ($route['method'] == $method) {
                $pattern = preg_replace('/\{[^\}]+\}/', '([0-9]+)', $route['uri']);
                if (preg_match("#^$pattern$#", $uri, $matches)) {
                    list($controller, $method) = explode('@', $route['controller']);
                    $controller = str_replace('/', '\\', $controller);
                    if (class_exists($controller)) {
                        $controller = new $controller;
                        if (method_exists($controller, $method)) {
                            array_shift($matches); // Remove the full match
                            return call_user_func_array([$controller, $method], $matches);
                        } else {
                            throw new Exception("Method $method not found in controller $controller.");
                        }
                    } else {
                        throw new Exception("Controller $controller not found.");
                    }
                }
            }
        }
        throw new Exception("No route matched.");
    }
}
