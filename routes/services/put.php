<?php

$response = new $controller();

if(strpos($routes[1],'?') !== false){
    if(isset($_GET['id'])){
        $response->update();
    }else{
        response_error();
    }
    die();
}

response_error();