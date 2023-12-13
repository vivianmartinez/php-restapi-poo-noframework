<?php

$response = new $controller();

if(count($routes) == 3){
    $method = $routes[2];
    if(method_exists($controller,$method)){
        $response->$method();
    }else{
        response_error();
    }
}else{
    response_error();
}