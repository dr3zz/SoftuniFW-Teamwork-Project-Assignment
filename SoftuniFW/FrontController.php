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

    }

    public static function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new \SoftUniFw\FrontController();
        }
        return self::$_instance;
    }
}