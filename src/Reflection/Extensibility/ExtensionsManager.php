<?php

//set the namespace
namespace BytesPhp\Reflection\Extensibility;

//import class(es) required
use BytesPhp\Reflection\ClassMetadata as ClassMetadata;
use BytesPhp\Primitives\Helpers\StringHelper as StringHelper;
use BytesPhp\IO\Helpers\IOHelper as IOHelper;

//the manager class
class ExtensionsManager{

    //public variable(s)
    public $SearchPaths = array(); //paths used for searching for extensions
    public $Interface = null;

    public $FileExtensionsToBeIgnored = array(); //file extensions to be ignored when scanning for extensions

    //private variable(s)
    private $extensionsCache = array();

    //constructor method
    function __construct(array $searchPaths = null, string $interface = null, bool $addDefaults = true) {
        
        if($searchPaths != null){
            $this->SearchPaths = $searchPaths;
        }

        if($interface != null){
            $this->Interface = $interface;
        }

        if ($addDefaults) {
        
            //add the extensions to be ignored (some media files cause issues in line 144)
            $this->FileExtensionsToBeIgnored [] = ".jpg";
        
        }
    
    }

    //returns a list of all files inside a given search path
    public function GetExtensions(array $paths = null, string $interface = null, array $metadata = null):array{

        //set the (default) search paths, if no path(s) is/are given
        if($paths == null) {
            $paths = $this->SearchPaths;
        }

        //set the (default) interface, if none given
        if($interface == null) {
            $interface = $this->Interface;
        }

        //create the output value
        $output = array();

        foreach(IOHelper::Files($paths) as $file) {
            $output = array_merge($output,$this->GetFileExtensions($file));
        }

        //validate the extension(s) found
        foreach($output as $index=>$extension){

            if($interface != null) { //check for implementing interface
                if(!$extension->Implements($interface)){
                    unset($output[$index]);
                }
            }

            if($metadata != null) { //check for specific metadata
                foreach($metadata as $key => $value) {

                    if(!$extension->metadata->ContainsKey($key)){ //the key was not found
                        unset($output[$index]);
                    }

                    if($value != null){
                        if($extension->metadata->$key != $value){ //the value was not matching
                            unset($output[$index]);
                        }
                    }

                }
            }
            
        }

        //return the output value
        return $output;

    }

    private function GetFileExtensions(string $path):array{
        
        //create the output value
        $output = array();

        //check for files to be ignored
        foreach($this->FileExtensionsToBeIgnored as $extension) {
        
            if(StringHelper::EndsWith($path,$extension)) {
            
                return $output;
            
            }
        
        }

        //check if the file exists
        if(!file_exists($path)){
            return $output;
        }

        //read the file and get all token(s)
        //based on the article found at 'http://wiki.birth-online.de/snippets/php/get-classes-in-file'
        $tokens = token_get_all(file_get_contents($path));
        $namespace = "";

        //iterate over tokens and create 'Extension' instance(s)
        for ($index = 0; isset($tokens[$index]); $index++) { //loop for each token found

            //skip empty token
            if (!isset($tokens[$index][0])) {
                continue;
            }

            //get the namespace
            if($tokens[$index][0] === T_NAMESPACE) {
                    
                // Skip namespace keyword and whitespace
                $index += 2; 
            
                //set the namespace
                while (isset($tokens[$index]) && is_array($tokens[$index])) {
                
                    $namespace .= $tokens[$index++][1];
                
                }
            
            }

            //get the class
            if($tokens[$index][0] === T_CLASS) {
                    
                // Skip class keyword and whitespace
                $index += 2; 
            
                //add the class to output
                $output[] = new Extension($path,$namespace.'\\'.$tokens[$index][1]);
            
            }

        }

        //return the output value
        return $output;

    }

}

?>