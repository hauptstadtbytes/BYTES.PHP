<?php

//set the namespace
namespace BytesPhp\Reflection\Extensibility;

//import class(es) required
use BytesPhp\Reflection\ClassMetadata as ClassMetadata;

//the extension class
class Extension{

    //private properties
    private $filePath = "";
    private $className = "";
    private $instance = null;
    private $metadata = null;

    //constructor method
    function __construct($filePath, $className) {
        
        //set the variable(s)
        $this->filePath = $filePath;
        $this->className = $className;
    
        //create a new class instance, if no constructor argument(s) is/ are required
        $reflection = new \ReflectionClass($className);
                
        if(is_null($reflection->getConstructor())) {
                    
            $this->instance = $this->GetInstance();
                    
        }
    
        //get the annotations
        $this->metadata = new ClassMetadata($this->className,$this->filePath);
    
    }

    //public getter method, for read-only properties
    public function __get(string $property) {
            
        switch(strtolower($property)) {
                
            case "filepath":
                return $this->filePath;
                break;
                
            case "classname":
                return $this->className;
                break;
                
            case "interfaces":
                if($this->instance == null) {
                    return array();
                } else {
                    $interfaces = class_implements($this->instance);

                    if(!$interfaces){
                        return array();
                    } else {
                        return $interfaces;
                    }
                }
                break;
                
            case "instance":
                return $this->instance;
                break;
                
            case "metadata":
                return $this->metadata;
                break;
                
            default:
                return null;
                
            
        }
        
    }

    //checks if a specific interface is implemented
    public function Implements(string $interface):bool{

        return in_array($interface,$this->interfaces);

    }

    //create a class instance
    private function GetInstance() {
        
        require_once($this->filePath);
    
        return new $this->className();
    
    }

}
?>