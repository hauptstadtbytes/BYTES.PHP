<?php

//set the namespace
namespace BytesPhp\Primitives;

//a case-insensitive array
class CaseInsensitiveArray implements \ArrayAccess, \Iterator
{
    //private properties
    private $container = array();
    private $position;

    //constructor
    public function __construct( Array $initialValues = array() ) {

        $this->container = array_map( "strtolower", $initialValues);
        $this->position = array_key_first($this->container);

    }

    //method(s) implementing 'ArrayAccess'
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

    //method(s) implementing 'Iterator'
    public function rewind(): void {
        reset($this->container);
    }

    #[\ReturnTypeWillChange]
    public function current() {
        return current($this->container);;
    }

    #[\ReturnTypeWillChange]
    public function key() {
        return key($this->container);
    }

    public function next(): void {
        next($this->container);
    }

    public function valid(): bool {
        return key($this->container) !== null;
    }

    //public method(s)
    public function Keys(): array{
        return array_keys($this->container);
    }

    public function Values(): array{
        return array_values($this->container);
    }

}

?>