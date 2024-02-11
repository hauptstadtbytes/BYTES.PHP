<?php

//set the namespace
namespace BytesPhp\Primitives;

//the metadata class
class Dictionary{

    //protected variable(s)
    protected $caseInsensitive = true;
    protected $pairs = array();

    //constructor method
    function __construct(array $items = null, array $defaults = null, $caseInsensitive = true) {

        //set the case sensitivity
        $this->caseInsensitive = $caseInsensitive;
    
        //set the default item(s)
        if(!is_null($defaults)) {
            
            $this->pairs = array_change_key_case($defaults,CASE_LOWER);
            
        }

        //load the item(s)
        if(!is_null($items)){
            $this->Load($items);
        }
        
    }

    //getter method
    function __get(string $key) {

        if($this->caseInsensitive){
            $key = strtolower($key);
        }
        
        if(array_key_exists($key, $this->pairs)) {
            
            return $this->pairs[$key];
            
        } else {
            
            return null;
            
        }
        
    }
    
    //setter method
    function __set(string $key, $value) {

        if($this->caseInsensitive){
            $key = strtolower($key);
        }
        
        $this->pairs[$key] = $value;
        
    }

    //method loading an array of values
    public function Load(array $items){

        if($this->caseInsensitive){
            $items = array_change_key_case($items,CASE_LOWER);
        }

        foreach($items as $key => $value){
            $this->pairs[$key] = $value;
        }

    }

    //method returning a list of all keys
    public function Keys():array{

        return array_keys($this->pairs);
    }

    //returns all key-value pairs
    public function Pairs():array{

        return $this->pairs;

    }

    //method for checking for a specific key
    public function ContainsKey(string $key):bool {

        if($this->caseInsensitive){
            $key = strtolower($key);
        }
            
        if(array_key_exists($key, $this->pairs)) {
                
            return true;
                
        } else {
                
            return false;
                
        }
        
    }
    
    //method checking for a specific value
    public function ContainsValue($value, $ignoreCase = true):bool {
            
        if($ignoreCase) { //checks if ignoring the case was requested
            
            foreach($this->pairs as $intValue) {
                    
                if(strtolower($intValue) == strtolower($value)) {
                        
                    return true;
                        
                }   
                    
            }
                
        } else { //continue if case sensity was requested
            
            if(($key = array_search($value, $this->pairs)) !== false) {
                
                return true;
                
            }
                
        }
        
        //return the default output value
        return false;
        
    }
        
    //method for checking for a specific key-value pair
    public function ContainsPair(string $key, string $value, bool $ignoreCase = true):bool {

        if($this->caseInsensitive){
            $key = strtolower($key);
        }
            
        if($ignoreCase) { //checks if ignoring the case was requested
            
            foreach($this->pairs as $currKey => $currValue) {
                
                if(($currKey == $key) && (strtolower($currValue) == strtolower($value))) {
                    
                    return true;
                
                }
                    
            }
        
        } else { //continue if case sensity was requested
        
            if($this->ContainsKey($key)) {
                
                if($this->pairs[$key] == $value) {
                    
                    return true;
                        
                }
                
            }
            
        }
        
        //return the output value
        return false;
            
    }

}
?>