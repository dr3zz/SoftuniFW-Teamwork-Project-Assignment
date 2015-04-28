<?php


namespace SoftUniFW;


class View
{

    private static $_instance = null;
    private $___viewPath = null;
    private $___viewDir = null;
    private $___extension = '.php';
    private $___data = array();

    private function __construct()
    {
        $this->___viewPath = \SoftUniFW\App::getInstance()->getConfig()->app['viewsDirectory'];
        if ($this->___viewPath == null) {
            $this->___viewPath = realpath('../views');
        }
    }

    public function setViewDirectory($path)
    {
        $path = trim($path);
        if ($path) {
            $path = realpath($path) . DIRECTORY_SEPARATOR;
            if (is_dir($path) && is_readable($path)) {
                $this->___viewDir = $path;
            } else {
                throw new \Exception('view path', 500);
            }
        } else {
            throw new \Exception('view path', 500);
        }
    }

    public function display($name, $data = array(), $returnAsString = false)
    {
        if (is_array($data)) {
            $this->___data = array_merge($this->___data, $data);
        }
        if ($returnAsString) {
            return $this->_includeFile($name);
        } else {
            echo $this->_includeFile($name);
        }

    }

    private function _includeFile($file)
    {
        if ($this->___viewDir == null) {
            $this->setViewDirectory($this->___viewPath);
        }

        $___fl = $this->___viewDir . str_replace('.', DIRECTORY_SEPARATOR, $file) . $this->___extension;
        if (file_exists($___fl) && is_readable($___fl)) {
            ob_start();
            include $___fl;
            return ob_get_clean();
        } else {
            throw new \Exception ('View ' . $file . ' cannot be included', 500);
        }
    }

    public function getData($name)
    {
        return $this->___data[$name];
    }

    public function setData($name, $value)
    {
        $this->___data[$name] = $value;
    }


    public static function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new \SoftUniFW\View();
        }
        return self::$_instance;
    }
}