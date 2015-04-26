<?php

namespace SoftUniFw;


class FrontController
{

    private static $_instance = null;
    private $ns = null;
    private $controller = null;
    private $method = null;

    private function __construct()
    {

    }


    public function dispatch()
    {
        $a = new \SoftUniFw\Routers\DefaultRouter();
        $_uri = $a->getURI();
        $routes = \SoftUniFw\App::getInstance()->getConfig()->routes;
        if (is_array($routes) && count($routes) > 0) {
            foreach ($routes as $key => $value) {
                if (stripos($_uri, $key) === 0 && $value['namespace']) {
                    $this->ns = $value['namespace'];
                    break;
                }
            }
        } else {
            throw new \Exception('Default route missing', 500);
        }
        if ($this->ns == null && $routes['*']['namespace']) {
            $this->ns = $routes['*']['namespace'];
//            $_rc = $routes['*']['controllers'];
        } else if ($this->ns == null && !$routes['*']['namespace']) {
            throw new \Exception('Default route missing', 500);
        }
        echo $this->ns;
    }

    public function getDefaultController()
    {
        $controller = \SoftUniFw\App::getInstance()->getConfig()->app['default_controller'];
        if ($controller) {
            return $controller;
        }
        return 'Index';
    }


    public function getDefaultMethod()
    {
        $method = \SoftUniFw\App::getInstance()->getConfig()->app['default_method'];
        if ($method) {
            return $method;
        }
        return 'index';
    }

    public static function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new \SoftUniFw\FrontController();
        }
        return self::$_instance;
    }
}