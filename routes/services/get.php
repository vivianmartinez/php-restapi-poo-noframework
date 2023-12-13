<?php

$response = new $controller();

if(strpos($routes[1],'?') !== false){
    if(isset($_GET['id'])){
        $response->single($_GET['id']);  
    }
}else{
    $method = $routes[1];
    if(method_exists($controller,$method)){
        $response->$method();
    }else{
        response_error();
    }
}