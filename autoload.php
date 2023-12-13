<?php

function app_autoload_models($class)
{
    require_once 'models/'.$class.'.php';
}

spl_autoload_register('app_autoload_models');