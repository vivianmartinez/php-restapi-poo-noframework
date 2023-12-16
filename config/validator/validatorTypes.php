<?php

namespace config\validator;

class ValidatorTypes
{
    static public function validateTypeBook($data)
    {
        foreach($data as $key => $value){
            if($key == 'title' || $key == 'description'){
                if(! is_string($value)){
                    return false;
                }
            }elseif(! is_integer($value)){
                return false;
            }
        }
        return true;
    }
}