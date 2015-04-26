<?php

namespace SoftUniFw;


final class Loader
{

    private static $namespaces = array();

    private function __construct()
    {

    }

    /**
     *
     */
    public static function registerAutoLoad()
    {
        spl_autoload_register(array('\SoftUniFw\Loader', 'autoload'));
    }

    public static function autoload($class)
    {

        self::loadClass($class);
    }

    public static function loadClass($class)
    {
        foreach (self::$namespaces as $key => $value) {
            if (strpos($class, $key) === 0) {
                $file = realpath(substr_replace(str_replace('\\', DIRECTORY_SEPARATOR, $class), $value, 0, strlen($key)) . '.php');
                if ($file && is_readable($file)) {
                    include $file;
                } else {
                    throw new \Exception('File cannot be included' . $file);
                }
                break;
            }
        }
    }

    public static function registerNamespace($namespace, $path)
    {
        $namespace = trim($namespace);
        if (strlen($namespace) > 0) {
            if (!$path) {
                throw new \Exception('Invalid path');
            }
            $_path = realpath($path);
            if ($_path && is_dir($_path) && is_readable($_path)) {
                self::$namespaces[$namespace . '\\'] = $_path . DIRECTORY_SEPARATOR;
            } else {
                throw new \Exception('Namespace directory read error:' . $path);
            }
        } else {
            throw new \Exception('Invalid namespace:' . $namespace);
        }
    }

    public static function registerNamespaces($ar)
    {
        if (is_array($ar)) {
            foreach ($ar as $key => $value) {
                self::registerNamespace($key, $value);
            }
        } else {
            throw new \Exception('Invalid namespaces');
        }
    }

    public static function getNamespaces()
    {
        return self::$namespaces;
    }

    public static function removeNamespace($namespace)
    {
        unset(self::$namespaces[$namespace]);
    }

    public static function clearNamespaces()
    {
        self::$namespaces = array();
    }
}