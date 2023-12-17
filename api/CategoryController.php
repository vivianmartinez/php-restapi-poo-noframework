<?php

use config\validator\ValidatorRequest;
use config\validator\ValidatorTypes;
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

        if(array_key_exists('name',$data)){
            $validateType = ValidatorTypes::validateTypeCategory($data);
            if($validateType){
                $this->category->setCategoryName(htmlspecialchars(strip_tags($data['name'])));
                
                $result = $this->category->create();

                if($result){
                    $find = $this->category->findOne();
                    $this->jsonResponse(200,$find);
                    return;
                }else{
                    $this->jsonResponse(500,'Something bad happened. Can\'t create new category.');
                    return;
                }
            }
        }else{
            $this->jsonResponse(404,'name cannot be null');
            return;
        }
        $this->jsonResponse(500,'Invalid json.');  
    
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
            $this->jsonResponse(500,'Bad request, empty json.');
            return;
        }
        //validate json properties
        $validateRequest = ValidatorRequest::validateRequest($this->category,$data);
        if($validateRequest)
        {
            $this->jsonResponse(500,'Invalid json.');
            return;
        }

        if(array_key_exists('name',$data)){
            
            $validateType = ValidatorTypes::validateTypeCategory($data);
            if($validateType){
                
                $this->category->setCategoryName(htmlspecialchars(strip_tags($data['name'])));
                $result = $this->category->update();
                if(!$result){
                    $this->jsonResponse(500,'Something bad happend. Can\'t update category.');
                    return;
                }
                $this->jsonResponse(200,$this->category->findOne());
                return;
            }
        }
        $this->jsonResponse(500,'Invalid json.');
    }
    /**
     * Delete category
     */
    public function delete()
    {
        $this->category->setId($this->request->id);
        $find = $this->category->findOne();
        if(empty($find)){
            $this->jsonResponse(404,'Category not found');
            return;
        }
        $result = $this->category->delete();
        $status = 200;
        if($result['error']){
            $status = 404;
        }
        $this->jsonResponse($status,$result['message']);
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