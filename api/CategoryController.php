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