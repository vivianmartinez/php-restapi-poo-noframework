<?php


$response = new $controller();

if(strpos($routes[1],'?') !== false){
    if(isset($_GET['id']) && $_GET['id'] !== null && $_GET['id'] !== ''){
        $response->single(); 
    }else{
        $json_response->json(500,'Bad request, you must send Id parameter.');
    }
}else{
    $method = $routes[1];
    if(method_exists($controller,$method)){
        $response->$method();
    }else{
        $json_response->json(500,'Bad request.');
    }
}