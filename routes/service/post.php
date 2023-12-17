<?php

$response = new $controller();

if(count($routes) == 3){
    $method = $routes[2];
    if(method_exists($controller,$method)){
        $response->$method();
    }else{
        $json_response->json(500,'Bad request.');
    }
}

$json_response->json(500,'Bad request.');