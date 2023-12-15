<?php



class CategoryController{

    private $category;

    public function __construct()
    {
        //instantiate category object
        $this->category = new Category();
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

    public function single($id)
    {
        $this->category->id = $id;
        if($this->category->id === null){
            $this->jsonResponse(500,'you must send the id parameter');
        }else{
            $find = $this->category->findOne();
            if(empty($find)){
                $this->jsonResponse(404,'Not found.');
                return;
            }
            $this->jsonResponse(200,$find);
        }  
    }
    /**
    * create category
    */
    public function create()
    {
        $jsonData = file_get_contents('php://input');
        // Decode the JSON data into a PHP associative array
        $data = json_decode($jsonData, true);
        if($data !== null){ 
            if(array_key_exists('category_name',$data)){
                $this->category->setCategoryName(htmlspecialchars(strip_tags($data['category_name'])));
               
                $result = $this->category->create();

                if($result){
                    $find = $this->category->findOne();
                    $this->jsonResponse(200,$find);
                }else{
                    $this->jsonResponse(404,'Something bad happened. Can\'t create new category.');
                }
            }else{
                $this->jsonResponse(403,'category_name cannot be null');
            }
        }else{
            $this->jsonResponse(404,'You must send a data json.');
        }
    }
    /**
     * update category
     */
    public function update()
    {
        $jsonData = file_get_contents('php://input');
        
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