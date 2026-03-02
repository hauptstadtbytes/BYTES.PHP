<?php
//set the namespace
namespace BytesPhp\Exceptions;

//add (PHP) global namespaces required
use RuntimeException;
use Throwable;

class MethodNotImplementedException extends RuntimeException{

    protected $message = 'Method not implemented';

}
?>