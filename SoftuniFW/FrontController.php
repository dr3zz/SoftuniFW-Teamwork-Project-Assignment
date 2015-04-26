<?php

namespace SoftUniFw;


class FrontController
{

    private static $_instance = null;
    private $ns = null;
    private $controller = null;
    private $method = null;
    private $router = null;

    private function __construct()
    {

    }

    public function getRouter()
    {
        return $this->router;
    }


    public function setRouter(\SoftUniFw\Routers\IRouter $router)
    {
        $this->router = $router;
    }




    public function dispatch()
    {
        if($this->router == null){
            throw new \Exception ('No valid router found', 500);
        }

        $_uri =$this->router->getURI();
        $routes = \SoftUniFw\App::getInstance()->getConfig()->routes;
        $_rc = null;
        if (is_array($routes) && count($routes) > 0) {
            foreach ($routes as $key => $value) {
                if (stripos($_uri, $key) === 0 && (($_uri == $key) || stripos($_uri, $key . '/') === 0) && $value['namespace']) {
                    $this->ns = $value['namespace'];
                    $_uri = substr($_uri, strlen($key) + 1);
                    $_rc = $value;
                    break;
                }
            }
        } else {
            throw new \Exception('Default route missing', 500);
        }
        if ($this->ns == null && $routes['*']['namespace']) {
            $this->ns = $routes['*']['namespace'];
            $_rc = $routes['*'];
        } else if ($this->ns == null && !$routes['*']['namespace']) {
            throw new \Exception('Default route missing', 500);
        }

        $_params = explode('/', $_uri);
        if ($_params[0]) {
            $this->controller = strtolower($_params[0]);
            if ($_params[1]) {
                $this->method = strtolower($_params[1]);
            } else {
                $this->method = $this->getDefaultMethod();
            }
        } else {
            $this->controller = $this->getDefaultController();
            $this->method = $this->getDefaultMethod();
        }

        if (is_array($_rc) && $_rc['controllers']) {

            if ($_rc['controllers'][$this->controller]['methods'][$this->method]) {
                $this->method = strtolower($_rc['controllers'][$this->controller]['methods'][$this->method]);
            }
            if (isset($_rc['controllers'][$this->controller]['to'])) {
                $this->controller = strtolower($_rc['controllers'][$this->controller]['to']);
            }
        }
        $f = $this->ns . '\\' . ucfirst($this->controller);
        $newController = new $f();
        $newController->{$this->method}();
    }

    public function getDefaultController()
    {
        $controller = \SoftUniFw\App::getInstance()->getConfig()->app['default_controller'];
        if ($controller) {
            return strtolower($controller);
        }
        return 'index';
    }


    public function getDefaultMethod()
    {
        $method = \SoftUniFw\App::getInstance()->getConfig()->app['default_method'];
        if ($method) {
            return strtolower($method);
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