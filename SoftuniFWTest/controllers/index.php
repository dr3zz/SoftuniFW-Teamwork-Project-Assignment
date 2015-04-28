<?php


namespace Controllers;
class Index
{
    public function index3()
    {
        $view = \SoftUniFW\View::getInstance();
        $view->username = 'dadas';
        $view->display('admin.index');
    }
}