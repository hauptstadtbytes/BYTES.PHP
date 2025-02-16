<?php
//set namespace
namespace BytesPhp\Tests\Reflection;

//import type(s) required
require_once("Test-Interface.php");

/**
 * @name Sample One
 * @description a simple example class
 * @version 1.0.0.0
 */
class SampleOne{
}

/**
 * @name Sample Two
 */
class SampleTwo{
}

/**
 * @name Addition
 * @description a simple calculator extension for addition
 * @version 1.0.0.0
 */
class AdditionExtension implements CalculatorExtension{

    //the calculator method
    public function Calculate($valOne, $valTwo){
        return $valOne + $valTwo;
    }

}


/**
 * @name Subtraction
 * @description a simple calculator extension for subtraction
 */
class SubtractionExtension implements CalculatorExtension{

    //the calculator method
    public function Calculate($valOne, $valTwo){
        return $valOne - $valTwo;
    }

}

//a class not being an extension
class NoExtension{}
?>