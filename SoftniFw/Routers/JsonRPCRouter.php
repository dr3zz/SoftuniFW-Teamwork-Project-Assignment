<?php


namespace SoftUniFW\Routers;


class JsonRPCRouter implements \SoftUniFW\Routers\IRouter
{
    public function __construct()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST' ||
            empty($_SERVER['CONTENT_TYPE']) || $_SERVER['CONTENT_TYPE'] != 'application/json') {
            throw new \Exception('Require json request', 400);
        }
    }

    public function getURI()
    {

    }

}