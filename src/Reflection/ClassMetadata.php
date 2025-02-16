<?php

//set the namespace
namespace BytesPhp\Reflection;

//import class(es) required
use BytesPhp\Primitives\Dictionary as Dictionary;

//the metadata class
class ClassMetadata extends Dictionary {

    //private variable(s)
    private $typeName = "";
    private $path = null;
        
    //constructor method
    function __construct(string $className, $path = null) {
        
        //initialize the parent class
        parent::__construct();
    
        //set the class name
        $this->typeName = $className;
        $this->pairs["type"] = $className;
        $this->path = $path;
    
        //parse the annotations
        $this->Parse();
    
    }

    //annotations parsing method
    private function Parse() {
        
        //create the dictionary
        $annotations = array();

        if(!is_null($this->path)){
            require_once($this->path);
        }

        //create the reflection class
        $rc = new \ReflectionClass($this->typeName);
    
        //get all string matches using RegEX
        preg_match_all("/@(\w+)\b(.*)/",$rc->getDocComment(), $annotations);
    
        //read the class annotations
        $annotations = array_combine($annotations[1], $annotations[2]); 
    
        foreach($annotations as $key => $value) {
            
            $this->pairs[$key] = trim($value);
            
        }
                    
    } 
}

?>