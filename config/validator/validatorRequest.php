<?php
namespace config\validator;

class ValidatorRequest
{
    static public function validateRequest($entity,$data)
    {
        $columns = $entity->columns();
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