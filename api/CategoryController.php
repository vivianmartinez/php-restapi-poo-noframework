<?php

use config\validator\ValidatorRequest;
use Service\HttpService\Request;

class CategoryController{

    private $category;
    public $request;

    public function __construct()
    {
        //instantiate category object
        $this->category = new Category();
        $this->request = new Request();
    }
    /**
     * get all categories
     */
    public function categories()
    {
        //category query
        $list_categories = $this->category->findAll();
        if(!empty($list_categories)){
            $this->jsonResponse(200,$list_categories);
        }else{
            $this->jsonResponse(404,'No data.');
        }
    }
    /**
     * get single category
     */

    public function single()
    {
        $this->category->setId($this->request->id);
        $find = $this->category->findOne();
        if(empty($find)){
            $this->jsonResponse(404,'Category not found.');
            return;
        }
        $this->jsonResponse(200,$find);
    }
    /**
    * create category
    */
    public function create()
    {
        $data = $this->request->data;
        if($data == null){ 
            $this->jsonResponse(500,'Bad request. Empty json');
            return;
        }

        if(array_key_exists('category_name',$data)){
            $this->category->setCategoryName(htmlspecialchars(strip_tags($data['category_name'])));
            
            $result = $this->category->create();

            if($result){
                $find = $this->category->findOne();
                $this->jsonResponse(200,$find);
            }else{
                $this->jsonResponse(500,'Something bad happened. Can\'t create new category.');
            }
        }else{
            $this->jsonResponse(404,'category_name cannot be null');
        }
    
    }
    /**
     * update category
     */
    public function update()
    {
        $this->category->setId($this->request->id);
        $find = $this->category->findOne();
        if(empty($find)){
            $this->jsonResponse(404,'Category not found.');
            return;
        }
        $data = $this->request->data;
        if($data == null){
            $this->jsonResponse(500,'Bad request. Empty json');
            return;
        }
        //validate json properties
        $validateRequest = ValidatorRequest::validateRequest($this->category,$data);
        if($validateRequest)
        {
            $this->jsonResponse(500,'Invalid json.');
            return;
        }

        if(array_key_exists('category_name',$data)){
            if(is_string($data['category_name'])){
                $this->category->setCategoryName(htmlspecialchars(strip_tags($data['category_name'])));
                $result = $this->category->update();
                if($result['error']){
                    $this->jsonResponse(500,$result['message']);
                    return;
                }
                $this->jsonResponse(100,$this->category->findOne());
                return;
            }
        }
        $this->jsonResponse(500,'Invalid json.');
    }
    /**
     * json response
     */
    public function jsonResponse($status, $data)
    {
        $response = ['status' => $status];
        if($status != 200){
            $response['message'] = $data;
        }else{
            $response['data'] = $data;
        };
        echo json_encode($response,http_response_code($status));
    }
}