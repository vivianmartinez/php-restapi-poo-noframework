<?php

use config\validator\ValidatorRequest;
use config\validator\ValidatorTypes;
use Service\HttpService\Request;
use Service\HttpService\JsonResponse;


class AuthorController{

    private $author;
    public  $request;
    public  $jsonResponse;

    public function __construct()
    {
        //instantiate author object
        $this->author = new Author();
        $this->request = new Request();
        $this->jsonResponse = new JsonResponse();
    }
    /**
     * get all authors
     */
    public function authors()
    {
        //author query
        $list_authors = $this->author->findAll();
        if(!empty($list_authors)){
            $this->jsonResponse->json(200,$list_authors);
        }else{
            $this->jsonResponse->json(404,'No data.');
        }
    }
    /**
     * get single author
     */

    public function single()
    {
        $this->author->setId($this->request->id);
        $find = $this->author->findOne();
        if(empty($find)){
            $this->jsonResponse->json(404,'Author not found.');
            return;
        }
        $this->jsonResponse->json(200,$find);
    }
    /**
     * create author
     */
    public function create()
    {
        $data = $this->request->data;
        if($data == null){
            $this->jsonResponse->json(500,'Bad request, empty json.');
            return;
        }
        if(array_key_exists('author_name',$data)){
            $validateType = ValidatorTypes::validateTypeAuthor($data);
            if($validateType){
                $this->author->setAuthorName(htmlspecialchars(strip_tags($data['author_name'])));
                
                $result = $this->author->create();

                if($result){
                    $find = $this->author->findOne();
                    $this->jsonResponse->json(200,$find);
                }else{
                    $this->jsonResponse->json(500,'Something bad happened. Can\'t create new author.');
                }
            }
        }else{
            $this->jsonResponse->json(404,'author_name cannot be null');
        }
    }
    /**
     * update author
     */
    public function update()
    {
        $this->author->setId($this->request->id);
        $find = $this->author->findOne();
        if(empty($find)){
            $this->jsonResponse->json(404,'Author not found.');
        }
        $data = $this->request->data;
        if($data == null){
            $this->jsonResponse->json(500,'Bad request, empty json.');
        }
        //validate json properties
        $validateRequest = ValidatorRequest::validateRequest($this->author,$data);
        if($validateRequest){
            $this->jsonResponse->json(500,'invalid json.');
        }
        if(array_key_exists('author_name',$data)){
            $validateType = ValidatorTypes::validateTypeAuthor($data);
            if($validateType){
                $this->author->setAuthorName(htmlspecialchars(strip_tags($data['author_name'])));
                $result = $this->author->update();
                if($result['error']){
                    $this->jsonResponse->json(500,$result['message']);
                }
                $this->jsonResponse->json(200,$this->author->findOne());
            }
        }else{
            $this->jsonResponse->json(404,'author_name cannot be null');
        }
        $this->jsonResponse->json(500,'Invalid json.');     
    }
    /**
     * Delete author
     */
    public function delete()
    {
        $this->author->setId($this->request->id);
        $find = $this->author->findOne();
        if(empty($find)){
            $this->jsonResponse->json(404,'Author not found');
        }
        $result = $this->author->delete();
        $status = 200;
        if($result['error']){
            $status = 404;
        }
        $this->jsonResponse->json($status,$result['message']);
    }
}