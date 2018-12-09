<?php

class Route
{
    private $path;
    private $callable;
    private $matches;
    public $restricted;

    public function __construct($restricted, $path, $callable)
    {
        $this->path = trim($path, '/');
        $this->callable = $callable;
        $this->restricted = $restricted;
    }

    public function match($url)
    {
        $url = trim($url, '/');
        $path = preg_replace("#:([\w]+)#", "([^/]+)", $this->path);
        $regex = "#^$path$#i";
        if (!preg_match($regex, $url, $matches)) {
            return (false);
        }
        array_shift($matches);
        $this->matches = $matches;
        return (true);
    }

    public function call()
    {
        return call_user_func_array($this->callable, $this->matches);
    }
}