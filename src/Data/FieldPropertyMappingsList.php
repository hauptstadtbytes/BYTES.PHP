<?php
//set the namespace
namespace BytesPhp\Data;

//import internal namespace(s) required
use BytesPhp\Reflection\Extensibility\Extensible as Extensible;

use BytesPhp\Data\FieldPropertyMapping as FieldPropertyMapping;

//the 'FieldPropertyMapping' class
class FieldPropertyMappingsList extends Extensible{

    //protected variable(s)
    protected array $mappings = [];

    protected ?array $indexByPropertyName = null;
    protected ?array $indexByFieldName = null;

    //constructor method
    function __construct(?array $mappings = null) {

        if(!is_null($mappings)){
            $this->mappings = $mappings;
        }

    }

    //(public) getter (magic) method, for read-only properties
    public function __get(string $property) {
            
        switch(strtolower($property)) {

            case "asarraybypropertyname":
                if(is_null($this->indexByPropertyName)) {
                    $this->indexByPropertyName = $this->GetIndex("PropertyName");
                }
                return $this->indexByPropertyName;
                break;

            case "asarraybyfieldname":
                if(is_null($this->indexByFieldName)) {
                    $this->indexByFieldName = $this->GetIndex("FieldName");
                }
                return $this->indexByFieldName;
                break;

            default:
                return null;
            
        }
        
    }

    //adds a new mapping to the internal array
    public function Add(FieldPropertyMapping $mapping){

        //validate the data
        if(array_key_exists($mapping->FieldName,$this->AsArrayByFieldName)) {
            throw new \InvalidArgumentException("Field '".$mapping->FieldName."' is already mapped");
        }

        if(array_key_exists($mapping->PropertyName,$this->AsArrayByPropertyName)) {
            throw new \InvalidArgumentException("Property '".$mapping->PropertyName."' is already mapped");
        }

        //add the mapping
        $this->mappings[] = $mapping;

        //update the index cache
        $this->indexByPropertyName = $this->GetIndex("PropertyName");
        $this->indexByFieldName = $this->GetIndex("FieldName");

    }

    //returns an array of all mappings, indexed by property or field name
    protected function GetIndex(string $indexer = "FieldName") : array {

        $output = [];

        foreach($this->mappings as $mapping) {
            $output[$mapping->$indexer] = $mapping;
        }

        return $output;

    }

}

?>