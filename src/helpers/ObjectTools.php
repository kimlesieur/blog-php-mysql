<?php 
namespace App\Helpers;

class ObjectTools {

    public static function fillFields($object, array $data, array $fields)
    {
        foreach($fields as $field){
            $method = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $field)));
            $object->$method($data[$field]);
        }
    }

    
}
