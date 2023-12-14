<?php


class BookController{
    private $book;
    private $author;
    private $category;

    public function __construct()
    {
        //instantiate book object
        $this->book = new Book();
        $this->author = new Author();
        $this->category = new Category();
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
            $not_null_fields = ['title','author_id','category_id'];
            $validate = $this->validate($data,$not_null_fields);
            if($validate->error){
                $this->jsonResponse($validate->status,$validate->message);
                return;
            }
            $this->book->setTitle(htmlspecialchars(strip_tags($data['title'])));
            //description can be null
            if(array_key_exists('description',$data)){
                $this->book->setDescription(htmlspecialchars(strip_tags($data['description'])));
            }
            //validate if exists author and category ids
            $foreign_entities = ['author' =>$this->author->setId($data['author_id']),
                                'category'=>$this->category->setId($data['category_id'])];

            $validateForeign = $this->validateForeign($foreign_entities);
            if($validateForeign->error){
                $this->jsonResponse($validateForeign->status,$validateForeign->message);
                return;
            }

            $this->book->setAuthorId(htmlspecialchars(strip_tags($data['author_id'])));
            $this->book->setCategoryId(htmlspecialchars(strip_tags($data['category_id'])));

            $result = $this->book->create();
            if($result){
                $find = $this->book->findOne();
                $this->jsonResponse(200,$find);
            }else{
                $this->jsonResponse(500,'Something bad happened. Can\'t create new book.');
            }
            
        }else{
            $this->jsonResponse(404,'Empty json.');
        }
    }
    /**
     * Update book
     */
    public function update()
    {
        $this->book->setId($_GET['id']);
        $find = $this->book->findOne();
        if(empty($find))
        {
            $this->jsonResponse(404,'Book not found');
            return;
        }
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData,true);
        if($data !== null){
            $this->book->setTitle($find['title']);
            $this->book->setDescription($find['description']);
            $this->book->setAuthorId($find['author_id']);
            $this->book->setCategoryId($find['category_id']);
            //verify data sended
            if(array_key_exists('title',$data)){
                $this->book->setTitle(htmlspecialchars(strip_tags($data['title'])));
            }
            if(array_key_exists('description',$data)){
                $this->book->setDescription(htmlspecialchars(strip_tags($data['description'])));
            }
            if(array_key_exists('author_id',$data)){
                //validate if exists author id
                $foreign_entities = ['author' =>$this->author->setId($data['author_id'])];
                $validateForeign = $this->validateForeign($foreign_entities);
                if($validateForeign->error){
                    $this->jsonResponse($validateForeign->status,$validateForeign->message);
                    return;
                }
                $this->book->setAuthorId(htmlspecialchars(strip_tags($data['author_id'])));
            }

            if(array_key_exists('category_id',$data)){
                //validate if exists category id
                $foreign_entities = ['category'=>$this->category->setId($data['category_id'])];
                $validateForeign = $this->validateForeign($foreign_entities);
                if($validateForeign->error){
                    $this->jsonResponse($validateForeign->status,$validateForeign->message);
                    return;
                }
                $this->book->setCategoryId(htmlspecialchars(strip_tags($data['category_id'])));
            }
            $result = $this->book->update();
            if($result['error']){
                $this->jsonResponse(500,$result['message']);
                return;
            }
            $this->jsonResponse(200,$this->book->findOne());
            
        }else{
            $this->jsonResponse(404,'Empty json.');
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
    /**
     * Validate data book
     */
    public function validate($data,$not_null)
    {
        $error = ['error' => false];
        foreach($not_null as $field){
            if(!array_key_exists($field,$data)){
                $error = ['error'=> true, 'status'=> 500,'message'=> $field.' cannot be null.'];
                return (Object)$error;
            }
        }
        return (Object)$error;
    }
    /**
     * validate foreign
     */
    public function validateForeign($entities)
    {
        $error = ['error' => false];
        foreach($entities as $key=>$entity){
            if(empty($entity->findOne()))
            {
                $error = ['error'=> true, 'status'=> 404,'message'=> $key.' not found.'];
                return (Object)$error;
            }
        }
        return (Object)$error;
    }
}