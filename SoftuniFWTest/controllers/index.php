<?php


namespace Controllers;
class Index
{
    public function index3()
    {
        $view = \SoftUniFW\View::getInstance();
        $view->username = 'az';
        $view->appendToLayout('body','admin.index');
        $view->appendToLayout('body2','index');
        $view->display('layouts.default', array('c'=>array(1,2,3,4,5,6)), false);

    }
}