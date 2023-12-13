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
            print_r($data);
        }else{
            $this->jsonResponse(404,'You must send a data json.');
        }
    }
    /**
     * json response
     */
    public function jsonResponse($status, $data)
    {
        $response = [
            'status' => $status,
            'data'=> $data
        ];
        echo json_encode($response,http_response_code($status));
    }
}