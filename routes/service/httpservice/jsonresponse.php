<?php

namespace Service\HttpService;

class JsonResponse
{
    public function json($status,$data) 
    {
        $response = ['status' => $status];
        if($status != 200){
            $response['message'] = $data;
        }else{
            $response['data'] = $data;
        };
        echo json_encode($response,http_response_code($status));
        exit();
    }
}