<?php

//set the namespace
namespace Bytes\BytesPhp\Primitives\Helpers;

class StringHelper{

//method returning a boolean value indicating wheather a string starts with a specific substring or not
static function StartsWith(string $haystack, string $needle, bool $caseSensitive = false) : bool {

    $length = strlen($needle);

    if($caseSensitive == false) {

      $haystack = strtolower($haystack);
      $needle = strtolower($needle);

    }

    if(substr($haystack, 0, $length) == $needle){

      return true;

    } else {

      return false;

    }

}

//method returning a boolean value indicating wheather a string ends with a specific substring or not
static function EndsWith(string $haystack, string $needle, bool $caseSensitive = false) : bool {

     $length = strlen($needle);

     if($caseSensitive == false) {

      $haystack = strtolower($haystack);
      $needle = strtolower($needle);

    }

     if ($length == 0) {

         return true;

     }

     if(substr($haystack, -$length) == $needle){

      return true;

    } else {

      return false;

    }

     //return (substr($haystack, -$length) === $needle);

 }

 //method returning a boolean value indicating wheather a substring is contained in a string or not
 static function Contains(string $haystack, string $needle, bool $caseSensitive = false):bool {

    if($caseSensitive == false) {

      $haystack = strtolower($haystack);
      $needle = strtolower($needle);

    }

    if(strpos($haystack,$needle)!== false){

      return true;

    } else {

      return false;

    }

}

}

?>