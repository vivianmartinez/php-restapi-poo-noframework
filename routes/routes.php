<?php

//Headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods:', 'GET,POST,PATCH,DELETE');
header('Content-Type: application/json');

//controllers 
require_once 'api/BookController.php';
require_once 'api/AuthorController.php';
require_once 'api/CategoryController.php';
//validators - service
require_once 'config/validator/validatorRequest.php';
require_once 'config/validator/validatorTypes.php';
require_once 'service/httpservice/request.php';
require_once 'service/httpservice/jsonresponse.php';

use Service\HttpService\JsonResponse;

$routes_url = $_SERVER['REQUEST_URI'];
$pos_api = strpos($routes_url,'/api/');

$json_response = new JsonResponse();

if($pos_api !== false){
    $routes = array_filter(explode('/',substr($routes_url,$pos_api)));
    if(empty($routes) || count($routes) < 2 || !isset($_SERVER['REQUEST_METHOD'])){
        $json_response->json(500,'Bad request.');
    }else{
        $routes = array_values($routes);
        //select controller
        $controller = RouteController::selectController($routes);
        if($controller == null){
            $json_response->json(500,'Bad request.');
        }

        switch($_SERVER['REQUEST_METHOD'])
        {
            case 'GET':
                require_once 'service/get.php';
                break;
            case 'POST':
                require_once 'service/post.php';
                break;
            case 'PATCH':
                require_once 'service/patch.php';
                break;
            case 'DELETE':
                require_once 'service/delete.php';
                break;
            default:
                $json_response->json(500,'Bad request.');
        }
    }
}else{
    $json_response->json(500,'Bad request.');
}