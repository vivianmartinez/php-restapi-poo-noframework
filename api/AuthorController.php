<?php


class AuthorController{

    private $author;

    public function __construct()
    {
        //instantiate author object
        $this->author = new Author();
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

    public function single($id)
    {
        $this->author->id = $id;
        if($this->author->id === null){
            $this->jsonResponse(500,'you must send the id parameter');
        }else{
            $find = $this->author->findOne();
            if(empty($find)){
                $this->jsonResponse(404,'Not found.');
                return;
            }
            $this->jsonResponse(200,$find);
        }  
    }
    /**
     * create author
     */
    public function create()
    {
        $jsonData = file_get_contents('php://input');
        // Decode the JSON data into a PHP associative array
        $data = json_decode($jsonData, true);
        if($data !== null){ 
            if(array_key_exists('author_name',$data)){
                $this->author->setAuthorName(htmlspecialchars(strip_tags($data['author_name'])));
               
                $result = $this->author->create();

                if($result){
                    $find = $this->author->findOne();
                    $this->jsonResponse(200,$find);
                }else{
                    $this->jsonResponse(404,'Something bad happened. Can\'t create new book.');
                }
            }else{
                $this->jsonResponse(403,'author_name cannot be null');
            }
        }else{
            $this->jsonResponse(404,'You must send a data json.');
        }
    }
    /**
     * update author
     */
    public function update()
    {
        $this->author->setId($_GET['id']);
        $find = $this->author->findOne();
        if(empty($find)){
            $this->jsonResponse(404,'author not found.');
            return;
        }
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData,true);
        if($data !== null){
            if(array_key_exists('author_name',$data)){
                $this->author->setAuthorName(htmlspecialchars(strip_tags($data['author_name'])));
                $result = $this->author->update();
                if($result['error']){
                    $this->jsonResponse(500,$result['message']);
                    return;
                }
                $this->jsonResponse(200,$this->author->findOne());
                return;
            }else{
                $this->jsonResponse(500,'Invalid json.');
                return;
            }
        }
        $this->jsonResponse(500,'Bad request. Empty json');
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