<?php


class BookController{
    private $book;

    public function __construct()
    {
        //instantiate book object
        $this->book = new Book();
    }
    /**
     * get all books
     */
    public function books()
    {
        //Book query
        $list_books = $this->book->findAll();
        if(!empty($list_books)){
            $this->jsonResponse(200,$list_books);
        }else{
            $this->jsonResponse(404,'No data.');
        }
    }
    /**
     * get single book
     */

    public function single($id)
    {
        $this->book->id = $id;
        if($this->book->id === null){
            $this->jsonResponse(500,'you must send the id parameter');
        }else{
            $find = $this->book->findOne();
            if(empty($find)){
                $this->jsonResponse(404,'Not found.');
                return;
            }
            $this->jsonResponse(200,$find);
        }  
    }
    /**
     * create book
     */
    public function create()
    {
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData,true);
        if($data !== null){
            if(array_key_exists('title',$data)){
                $this->book->setTitle(htmlspecialchars(strip_tags($data['title'])));
            }else{
                $this->jsonResponse(500,'Title cannot be null.');
            }
            if(array_key_exists('description',$data)){
                $this->book->setDescription(htmlspecialchars(strip_tags($data['description'])));
            }
            if(array_key_exists('author_id',$data)){
                $this->book->setAuthorId(htmlspecialchars(strip_tags($data['author_id'])));
            }else{
                $this->jsonResponse(500,'author id cannot be null.');
            }
            if(array_key_exists('category_id',$data)){
                $this->book->setCategoryId(htmlspecialchars(strip_tags($data['category_id'])));
            }else{
                $this->jsonResponse(500,'category id cannot be null.');
            }

            $result = $this->book->create();
            if($result){
                $find = $this->book->findOne();
                $this->jsonResponse(200,$find);
            }else{
                $this->jsonResponse(500,'Something bad happened. Can\'t create new book.');
            }
            
        }else{
            $this->jsonResponse(404,'You must send a data json.');
        }
    }
    /**
     * Delete book
     */
    public function delete()
    {
        $this->book->setId($_GET['id']);
        $find = $this->book->findOne();
        if(empty($find)){
            $this->jsonResponse(404,'Book not found');
            return;
        }
        $result = $this->book->delete();
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