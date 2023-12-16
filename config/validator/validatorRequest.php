<?php
namespace config\validator;

class ValidatorRequest
{
    static public function validateRequest($table,$data)
    {
        //check if any of properties sent in json is not a column
        $columns = $table->columns();
        $invalid = false;
        if($columns !== null){
            foreach($data as $key=>$value)
            {
                if(!in_array($key,array_column($columns,'item'))){
                    $invalid = true;
                }   
            }
        }
        return $invalid;
    }
}