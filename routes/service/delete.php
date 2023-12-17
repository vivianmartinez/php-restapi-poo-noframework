<?php

$response = new $controller();

if(strpos($routes[1],'?') !== false){
    if(! isset($_GET['id'])){
        $json_response->json(500,'Bad request. You must send Id parameter.');
    }
    $response->delete();
}

$json_response->json(500,'Bad request.');