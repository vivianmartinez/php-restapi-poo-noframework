<?php

//Headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods:', 'GET,POST,PUT,DELETE');
header('Content-Type: application/json');

//controllers 
require_once 'api/BookController.php';
require_once 'api/AuthorController.php';
require_once 'api/CategoryController.php';
require_once 'config/validator/validatorRequest.php';

//error response
function response_error(){
    $json = array(
            'status' => 500,
            'message' => 'Bad Request'
            );
    echo json_encode($json, http_response_code($json["status"]));
    return;
}

$routes_url = $_SERVER['REQUEST_URI'];
$pos_api = strpos($routes_url,'/api/');

if($pos_api !== false){
    $routes = array_filter(explode('/',substr($routes_url,$pos_api)));
    if(empty($routes) || count($routes) < 2 || !isset($_SERVER['REQUEST_METHOD'])){
        response_error();
    }else{
        $routes = array_values($routes);
        //select controller
        $controller = RouteController::selectController($routes);

        switch($_SERVER['REQUEST_METHOD'])
        {
            case 'GET':
                require_once 'services/get.php';
                break;
            case 'POST':
                require_once 'services/post.php';
                break;
            case 'PATCH':
                require_once 'services/patch.php';
                break;
            case 'DELETE':
                require_once 'services/delete.php';
                break;
            default:
                response_error();
        }
    }
}else{
    response_error();
}