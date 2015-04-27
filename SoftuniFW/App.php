<?php

namespace SoftUniFw;
include_once 'Loader.php';

class App
{
    private static $_instance = null;
    private $_config = null;
    private $_frontController = null;
    private $router = null;
    private $_dbConnections = array();

    private function __construct()
    {
        \SoftUniFw\Loader::registerNamespace('SoftUniFw', dirname(__FILE__) . DIRECTORY_SEPARATOR);
        \SoftUniFw\Loader::registerAutoLoad();
        $this->_config = \SoftUniFw\Config::getInstance();
        if ($this->_config->getConfigFolder() == null) {
            $this->setConfigFolder('../config');
        }
    }

    public function setConfigFolder($path)
    {
        $this->_config->setConfigFolder($path);
    }

    public function getConfigFolder()
    {
        return $this->_config->getConfigFolder();
    }


    public function getRouter()
    {
        return $this->router;
    }

    public function setRouter($router)
    {
        $this->router = $router;
    }


    public function getConfig()
    {
        return $this->_config;
    }

    public function run()
    {
        if ($this->_config->getConfigFolder() == null) {
            $this->setConfigFolder('../config');
        }
        $this->_frontController = \SoftUniFw\FrontController::getInstance();
        if ($this->router instanceof \SoftUniFw\Routers\IRouter) {
            $this->_frontController->setRouter($this->router);
        } else if ($this->router == 'JsonRPCRouter') {
            $this->_frontController->setRouter(new \SoftUniFw\Routers\DefaultRouter());
        } else if ($this->router == 'CLIRouter') {
            $this->_frontController->setRouter(new \SoftUniFw\Routers\DefaultRouter());
        } else {
            $this->_frontController->setRouter(new \SoftUniFw\Routers\DefaultRouter());
        }

        $this->_frontController->dispatch();
    }


    /**
     * @param string $connection
     * @return mixed
     * @throws \Exception
     */
    public function getDBConnection($connection = 'default')
    {
        if (!$connection) {
            throw new \Exception('No connection identifier provided', 500);
        }
        if($this->_dbConnections[$connection]) {
            return $this->_dbConnections[$connection];
        }
        $_cnf = $this->getConfig()->database;
        if(!$_cnf[$connection]) {
            throw new \Exception('No valid connection identificator is provided',500);
        }
        $dbh = new \PDO($_cnf[$connection]['connection_uri'],$_cnf[$connection]['username'],
            $_cnf[$connection]['password'],$_cnf[$connection]['pdo_options']);
        $this->_dbConnections[$connection] = $dbh;
        return $dbh;

    }

    /**
     * @return \SoftUniFw\App
     *
     */
    public static function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new \SoftUniFw\App();
        }
        return self::$_instance;
    }
}