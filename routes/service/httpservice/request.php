<?php

namespace Service\HttpService;

class Request{

    public $data;
    public $id;

    public function __construct()
    {
        $this->id = isset($_GET['id']) ? $_GET['id'] : null;
        $this->requestJson();
    }
    public function requestJson(){
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData,true);
        $this->data = $data;
        /*
        if($_SERVER['REQUEST_METHOD'] == 'POST' 
            || $_SERVER['REQUEST_METHOD'] = 'PATCH'){
            $jsonData = file_get_contents('php://input');
            $data = json_decode($jsonData,true);
            $this->request = $data;
        }
        */
    }
}