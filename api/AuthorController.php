<?php

use config\validator\ValidatorRequest;
use config\validator\ValidatorTypes;
use Service\HttpService\Request;


class AuthorController{

    private $author;
    public $request;

    public function __construct()
    {
        //instantiate author object
        $this->author = new Author();
        $this->request = new Request();
    }
    /**
     * get all authors
     */
    public function authors()
    {
        //author query
        $list_authors = $this->author->findAll();
        if(!empty($list_authors)){
            $this->jsonResponse(200,$list_authors);
        }else{
            $this->jsonResponse(404,'No data.');
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
            $this->jsonResponse(404,'Author not found.');
            return;
        }
        $this->jsonResponse(200,$find);
    }
    /**
     * create author
     */
    public function create()
    {
        $data = $this->request->data;
        if($data == null){
            $this->jsonResponse(500,'Bad request. Empty json');
            return;
        }
        if(array_key_exists('author_name',$data)){
            $validateType = ValidatorTypes::validateTypeAuthor($data);
            if($validateType){
                $this->author->setAuthorName(htmlspecialchars(strip_tags($data['author_name'])));
                
                $result = $this->author->create();

                if($result){
                    $find = $this->author->findOne();
                    $this->jsonResponse(200,$find);
                }else{
                    $this->jsonResponse(500,'Something bad happened. Can\'t create new author.');
                }
            }
        }else{
            $this->jsonResponse(404,'author_name cannot be null');
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
            $this->jsonResponse(404,'author not found.');
            return;
        }
        $data = $this->request->data;
        if($data == null){
            $this->jsonResponse(500,'Bad request. Empty json');
            return;
        }
        //validate json properties
        $validateRequest = ValidatorRequest::validateRequest($this->author,$data);
        if($validateRequest){
            $this->jsonResponse(500,'Invalid json.');
            return;
        }
        if(array_key_exists('author_name',$data)){
            $validateType = ValidatorTypes::validateTypeAuthor($data);
            if($validateType){
                $this->author->setAuthorName(htmlspecialchars(strip_tags($data['author_name'])));
                $result = $this->author->update();
                if($result['error']){
                    $this->jsonResponse(500,$result['message']);
                    return;
                }
                $this->jsonResponse(200,$this->author->findOne());
                return;
            }
        }else{
            $this->jsonResponse(404,'author_name cannot be null');
            return;
        }
        $this->jsonResponse(500,'Invalid json.');     
    }
    /**
     * Delete author
     */
    public function delete()
    {
        $this->author->setId($_GET['id']);
        $find = $this->author->findOne();
        if(empty($find)){
            $this->jsonResponse(404,'Author not found');
            return;
        }
        $result = $this->author->delete();
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