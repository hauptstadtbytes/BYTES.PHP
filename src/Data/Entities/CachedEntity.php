<?php
//set the namespace
namespace BytesPhp\Data\Entities;

//add internal namespace(s) required
use BytesPhp\Data\FieldPropertyMapping as FieldPropertyMapping;
use BytesPhp\Data\FieldPropertyMappingsList as FieldPropertyMappingsList;

use BytesPhp\Exceptions\MethodNotImplementedException as MethodNotImplementedException;

abstract class CachedEntity {

    //protected properties
    protected array $data = [];

    //constructor method(s)
    public function __construct(?array $data = null){

        if(!is_null($data)){
            $this->data = $data;
        }

    } 

    //returns all instances of the entity
    public static function All(?array $where = null) {

        //get the child class type name
        $class = get_called_class();

        //create the output list
        $output = [];

        foreach(static::Enumerate($where) as $instanceData) { //loop for all instances found

                $output[] = new $class($instanceData);

        }

        //return the output
        return $output;

    }

    //returns the first instance of the entity
    public static function First(?array $where = null) {

        //get the child class type name
        $class = get_called_class();

        foreach(static::Enumerate($where) as $instanceData) {
            return new $class($instanceData);
        }

    }

    //public (magic) getter method
    public function __get(string $property) {
            
        //check for a property overwrite
        $data = $this->ReadProperty($property,static::GetPropertyMappings());

        if(!is_null($data)){
            return $data;
        }

        //return the default value
        switch(strtolower($property)) {

            case "asarray":
                return $this->data;
                break;

            case "asjson":
                return json_encode($this->data);
                break;
                
            default:

                //return the property by mapping
                $internalFieldName = $property;
                if(array_key_exists(strtolower($property),$mappings->AsArrayByPropertyName)){

                    $internalFieldName = $mappings->AsArrayByPropertyName[strtolower($property)]->fieldname;

                    if(array_key_exists($internalFieldName,$this->data)){
                        return $this->data[$internalFieldName];
                    }
                }

                //return the property by internal name
                if(array_key_exists($property,$this->data)){
                    return $this->data[$property];
                }
                
                //return NULL by default
                return null;
                 
        }
        
    }

    //public (magic) property setter method
    public function __set($property, $value) {

        return $this->WriteProperty($property, $value, static::GetPropertyMappings());

    }

    //protected method, intended for overwriting propterty mapping
    protected static function GetPropertyMappings() : FieldPropertyMappingsList {

        $srcList = [];
        return new FieldPropertyMappingsList($srcList);

    }

    //enumeration method, intended for returning a (filtered) list of all entities available
    protected static function Enumerate(?array $where = null) {

        throw new MethodNotImplementedException("'Enumerate' method not implemented");

    }

    //property reading method, intended for overwriting proptery reading or adding additional properties in child classes
    protected function ReadProperty(string $property, FieldPropertyMappingsList $mappings) {

        return null;

    }

    //property writing method, intended for overwriting proptery writing child classes
    protected function WriteProperty($property, $value, FieldPropertyMappingsList $mappings) {

        //try to get the (internal) property name by mapping
        if(array_key_exists(strtolower($property),$mappings->AsArrayByPropertyName)){
            $property = $mappings->AsArrayByPropertyName[strtolower($property)]->fieldname;
        }

        //set the property
        $this->data[$property] = $value;

    }

    //compares the data given against the filter statement
    protected static function MatchesWhere(array $data, array $where) : bool {

        //get the list of mappings
        $mappings = static::GetPropertyMappings();
        $propertyMappings = $mappings->AsArrayByPropertyName;

        //check each filter statement
        foreach($where as $filterField => $filterValue) {

            //check for a mapped value
            if(array_key_exists(strtolower($filterField),$propertyMappings)) {

                $internalFilterField = $propertyMappings[strtolower($filterField)];

                if(!array_key_exists($internalFilterField,$data)) { //there is no field existing
                    return false;
                }

                if($data[$internalFilterField] != $filterValue) { //the values do not match
                    return false;
                }

            } else {

                if(!array_key_exists($filterField,$data)) { //there is no field existing
                    return false;
                }

                if($data[$filterField] != $filterValue) { //the values do not match
                    return false;
                }
                
            }

        }

        //return the default output value
        return true;

    }

}
?>