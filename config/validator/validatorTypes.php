<?php

namespace config\validator;

class ValidatorTypes
{
    //validate type data book
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
    //validate type data author
    static public function validateTypeAuthor($data)
    {
        if(is_string($data['author_name'])){
            return true;
        }
        return false;
    }
    //validate type data category
    static public function validateTypeCategory($data)
    {
        if(is_string($data['name'])){
            return true;
        }
        return false;
    }
}