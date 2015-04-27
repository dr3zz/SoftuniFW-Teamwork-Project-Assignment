<?php

namespace SoftUniFW\Routers;
use \SoftUniFW\Routers as IRouter;

class DefaultRouter implements IRouter\IRouter
{
    public function getURI()
    {
      return substr($_SERVER['PHP_SELF'], strlen($_SERVER['SCRIPT_NAME']) + 1);
    }
}