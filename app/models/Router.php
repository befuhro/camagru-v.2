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

    public function get($restricted, $path, $callable)
    {
        $route = new Route($restricted, $path, $callable);
        $this->routes['GET'][] = $route;
    }

    public function post($restricted, $path, $callable)
    {
        $route = new Route($restricted, $path, $callable);
        $this->routes['POST'][] = $route;
    }

    public function lookFor()
    {
        if (!isset($this->routes[$_SERVER["REQUEST_METHOD"]])) {
            throw new Exception("This method is not be handled by our server", 405);
        }
        foreach ($this->routes[$_SERVER["REQUEST_METHOD"]] as $route) {
            if ($route->match($this->url)) {
                if ($route->restricted === true && !isset($_SESSION["username"])) {
                    throw new Exception("You are not authorized to access this webpage.", 401);
                }
                else {
                    return ($route->call());
                }
            }
        }
        throw new Exception("URL doesn't exist.", 404);
    }
}