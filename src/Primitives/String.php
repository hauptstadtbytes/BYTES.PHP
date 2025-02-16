<?php
//returns a boolean, indicating wheather a string starts with a specific substring or not
function string_startswith(string $haystack, string $needle, bool $caseSensitive = false) : bool {

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

//returns a boolean, indicating wheather a string ends with a specific substring or not
function string_endswith(string $haystack, string $needle, bool $caseSensitive = false) : bool {

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

 //returns a boolean, indicating wheather a substring is contained in a string or not
 function string_contains(string $haystack, string $needle, bool $caseSensitive = false):bool {

  if($caseSensitive == false) {

    $haystack = strtolower($haystack);
    $needle = strtolower($needle);

  }

  if(strpos($haystack,$needle)!== false){

      return true;

  } 

  return false;

}
?>