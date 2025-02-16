<?php
//set the namespace
namespace BytesPhp\Reflection;

//import internal namespace(s) required
use BytesPhp\IO\FileInfo as FileInfo;

use BytesPhp\Reflection\ClassMetadata as ClassMetadata;

//the 'ClassInfo' class
class ClassInfo{

    //protected variable(s)
    protected ?FileInfo $file = null;
    protected ?string $name = null;

    //constructor method
    function __construct(string $filePath, string $name) {

        $this->file = new FileInfo($filePath);
        $this->name = $name;

    }

    //(public) getter (magic) method, for read-only properties
    public function __get(string $property) {
            
        switch(strtolower($property)) {

            case "file":
                return $this->file;
                break;

            case "name":
                return $this->name;
                break;

            case "metadata":
                return new ClassMetadata($this->name,$this->file->path);
                break;

            case "instance":
                return $this->GetInstance();
                break;

            case "interfaces":
                return $this->GetImplementedInterfaces();
                 break;

            default:
                return null;
            
        }
        
    }

    //checks if a given interface is implemented
    public function ImplementsInterface(string $interface): bool {

        if(in_array($interface, $this->interfaces)){
            return true;
        }

        return false;
    }

    //returns a class instance
    private function GetInstance() {
        
        require_once($this->file->path);
    
        return new $this->name();
    
    }

    //returns the list of implemented interfaces
    private function GetImplementedInterfaces(){

        $interfaces = class_implements($this->instance);

        if(!$interfaces){
            return [];
        } else {
            return $interfaces;
        }

    }

}

?>