<?php


$response = new $controller();

if(strpos($routes[1],'?') !== false){
    if(isset($_GET['id']) && $_GET['id'] !== null ){
        $response->single(); 
    }else{
        response_error();
    }
}else{
    $method = $routes[1];
    if(method_exists($controller,$method)){
        $response->$method();
    }else{
        response_error();
    }
}