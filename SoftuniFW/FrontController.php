<?php

namespace SoftUniFw;


class FrontController
{

    private static $_instance = null;

    private function __construct()
    {

    }


    public function dispatch()
    {
        $a = new \SoftUniFw\Routers\DefaultRouter();
        $a->parse();
        $controller = $a->getController();
        $method = $a->getMethod();

        if ($controller == null) {
            $controller = $this->getDefaultController();
        }
        if ($method == null) {
            $method = $this->getDefaultMethod();
        }

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