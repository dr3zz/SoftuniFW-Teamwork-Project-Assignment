<?php

namespace SoftUniFw\Routers;
class DefaultRouter implements \SoftUniFw\Routers\IRouter
{
    public function getURI()
    {
      return substr($_SERVER['PHP_SELF'], strlen($_SERVER['SCRIPT_NAME']) + 1);
    }
}