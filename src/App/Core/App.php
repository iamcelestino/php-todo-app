<?php

declare(strict_types=1);

namespace App\Core;

class HomeController 
{
    protected $controller = "homeController";
    protected $method = "index";
    protected $parameters = [];

    public function __construct() {
        $url = $this->parseUrl();

        if(isset($url[0]) && file_exists('../App/controllers'. $url[0] . 'controller.php')){
            $this->controller = 'App\\Controllers\\' . $url[0] . 'Controller';
            unset($url[0]);
        }
        else {
            $this->controller = 'App\\Controllers\\' .$this->controller;
        }

        $this->controller = new $this->controller;

        if(isset($url[1]) && method_exists($this->controller, $url[0])) {
            $this->method = $url[1];
            unset($url[1]);
        }

        $this->parameters = $url ? array_values($url): [];
        call_user_func_array([$this->controller, $this->method], $this->parameters);
    }

    public function parseUrl() {
        if(isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }
}