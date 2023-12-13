<?php

class RouteController{
    static public function route(){
        include_once 'routes/routes.php';
    }
    static public function selectController($routes)
    {
        if(str_contains($routes[1],'book')){
            $controller = 'BookController';
        }elseif(str_contains($routes[1],'author')){
            $controller = 'AuthorController';
        }elseif(str_contains($routes[1],'categor')){
            $controller = 'CategoryController';
        }
        return $controller;
    }
}