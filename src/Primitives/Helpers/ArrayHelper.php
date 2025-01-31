<?php

//set the namespace
namespace BytesPhp\Primitives\Helpers;

class ArrayHelper{

    //removes item(s) by index value from array
    static function Remove(array $haystack, array $needles) : array {

        $output = $haystack;

        foreach($needles as $needle) {

            if(array_key_exists($needle,$output)){

                $key = array_search($needle, $output);

                if ($key !== false) {
                    unset($output[$key]);
                }

            }

        }

        return $output;

    }

}

?>