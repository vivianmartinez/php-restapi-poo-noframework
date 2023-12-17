<?php

use config\validator\ValidatorRequest;
use config\validator\ValidatorTypes;
use Service\HttpService\JsonResponse;
use Service\HttpService\Request;


class CategoryController{

    private $category;
    public  $request;
    public  $jsonResponse;

    public function __construct()
    {
        //instantiate category object
        $this->category = new Category();
        $this->request = new Request();
        $this->jsonResponse = new JsonResponse();
    }
    /**
     * get all categories
     */
    public function categories()
    {
        //category query
        $list_categories = $this->category->findAll();
        if(!empty($list_categories)){
            $this->jsonResponse->json(200,$list_categories);
        }else{
            $this->jsonResponse->json(404,'No data.');
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
            $this->jsonResponse->json(404,'Category not found.');
        }
        $this->jsonResponse->json(200,$find);
    }
    /**
    * create category
    */
    public function create()
    {
        $data = $this->request->data;
        if($data == null){ 
            $this->jsonResponse->json(500,'Bad request. Empty json');
        }

        if(array_key_exists('name',$data)){
            $validateType = ValidatorTypes::validateTypeCategory($data);
            if($validateType){
                $this->category->setCategoryName(htmlspecialchars(strip_tags($data['name'])));
                
                $result = $this->category->create();

                if($result){
                    $find = $this->category->findOne();
                    $this->jsonResponse->json(200,$find);
                }else{
                    $this->jsonResponse->json(500,'Something bad happened. Can\'t create new category.');
                }
            }
        }else{
            $this->jsonResponse->json(404,'name cannot be null');
        }
        $this->jsonResponse->json(500,'Invalid json.');  
    
    }
    /**
     * update category
     */
    public function update()
    {
        $this->category->setId($this->request->id);
        $find = $this->category->findOne();
        if(empty($find)){
            $this->jsonResponse->json(404,'Category not found.');
        }
        $data = $this->request->data;
        if($data == null){
            $this->jsonResponse->json(500,'Bad request, empty json.');
        }
        //validate json properties
        $validateRequest = ValidatorRequest::validateRequest($this->category,$data);
        if($validateRequest)
        {
            $this->jsonResponse->json(500,'Invalid json.');
        }

        if(array_key_exists('name',$data)){
            
            $validateType = ValidatorTypes::validateTypeCategory($data);
            if($validateType){
                
                $this->category->setCategoryName(htmlspecialchars(strip_tags($data['name'])));
                $result = $this->category->update();
                if(!$result){
                    $this->jsonResponse->json(500,'Something bad happend. Can\'t update category.');
                }
                $this->jsonResponse->json(200,$this->category->findOne());
            }
        }
        $this->jsonResponse->json(500,'Invalid json.');
    }
    /**
     * Delete category
     */
    public function delete()
    {
        $this->category->setId($this->request->id);
        $find = $this->category->findOne();
        if(empty($find)){
            $this->jsonResponse->json(404,'Category not found');
        }
        $result = $this->category->delete();
        $status = 200;
        if($result['error']){
            $status = 404;
        }
        $this->jsonResponse->json($status,$result['message']);
    }
}