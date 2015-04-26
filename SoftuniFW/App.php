<?php

namespace SoftUniFw;
include_once 'Loader.php';

class App
{
    private static $_instance = null;
    private $_config = null;
    private $_frontController = null;

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

    public function getConfig(){
        return $this->_config;
    }

    public function run()
    {
        if ($this->_config->getConfigFolder() == null) {
            $this->setConfigFolder('../config');
        }
        $this->_frontController = \SoftUniFw\FrontController::getInstance();
        $this->_frontController->dispatch();
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