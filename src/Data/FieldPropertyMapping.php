<?php
//set the namespace
namespace BytesPhp\Data;

//import internal namespace(s) required
use BytesPhp\Reflection\Extensibility\Extensible as Extensible;

//the 'FieldPropertyMapping' class
class FieldPropertyMapping extends Extensible{

    //protected variable(s)
    protected string $propertyName;
    protected string $fieldName;

    //constructor method
    function __construct(string $propertyName, string $fieldName) {

        $this->propertyName = $propertyName;
        $this->fieldName = $fieldName;

    }

    //(public) getter (magic) method, for read-only properties
    public function __get(string $property) {
            
        switch(strtolower($property)) {

            case "fieldname":
                return $this->fieldName;
                break;

            case "propertyname":
                return $this->propertyName;
                break;

            default:
                return null;
            
        }
        
    }

}

?>