<?php

class RouteController{
    static public function route(){
        include_once 'routes/routes.php';
    }
    //return controller 
    static public function selectController($routes)
    {
        $controller = null;
        if(str_contains($routes[1],'book?') || $routes[1] == 'books'){
                $controller = 'BookController';
        }elseif(str_contains($routes[1],'author?') || $routes[1] == 'authors'){
                $controller = 'AuthorController';
        }elseif(str_contains($routes[1],'category?') || $routes[1] == 'categories'){
                $controller = 'CategoryController';
        }
        return $controller;
    }
}