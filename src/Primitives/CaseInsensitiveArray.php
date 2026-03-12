<?php

//set the namespace
namespace BytesPhp\Primitives;

//a case-insensitive array
class CaseInsensitiveArray implements \ArrayAccess
{
    private $container = array();

    public function __construct( Array $initial_array = array() ) {
        $this->container = array_map( "strtolower", $initial_array );
    }

    public function offsetSet($offset, $value): void {

        if( is_string( $offset ) ) $offset = strtolower($offset);

        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }

    }

    public function offsetExists($offset): bool {

        if( is_string( $offset ) ) $offset = strtolower($offset);
        return isset($this->container[$offset]);

    }

    public function offsetUnset($offset): void {

        if( is_string( $offset ) ) $offset = strtolower($offset);
        unset($this->container[$offset]);

    }

    public function offsetGet($offset): mixed {

        if( is_string( $offset ) ) $offset = strtolower($offset);
        return isset($this->container[$offset])
            ? $this->container[$offset]
            : null;

    }

}

?>