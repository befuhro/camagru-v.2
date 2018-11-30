<?php
require_once "Route.php";


class Router
{
    private $url;
    private $routes = array();

    public function __construct($url)
    {
        $this->url = $url;

    }

    public function get($path, $callable)
    {
        $route = new Route($path, $callable);
        $this->routes['GET'][] = $route;
    }

    public function post($path, $callable)
    {
        $route = new Route($path, $callable);
        $this->routes['POST'][] = $route;
    }

    public function lookFor()
    {
        if (!isset($this->routes[$_SERVER["REQUEST_METHOD"]])) {
            throw new Exception("This methods is not handled by our website");
        }
        foreach ($this->routes[$_SERVER["REQUEST_METHOD"]] as $route) {
            if ($route->match($this->url)) {
                return ($route->call());
            }
        }
        throw new Exception("No matching routes");
    }
}