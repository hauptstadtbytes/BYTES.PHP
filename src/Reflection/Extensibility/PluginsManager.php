<?php
//set the namespace
namespace BytesPhp\Reflection\Extensibility;

//import class(es) required
use BytesPhp\Reflection\ClassInfo as ClassInfo;
use BytesPhp\Reflection\ClassMetadata as ClassMetadata;

use BytesPhp\IO\FolderInfo as FolderInfo;
use BytesPhp\IO\FileInfo as FileInfo;

//the manager class
class PluginsManager{

    //public variable(s)
    public $SearchPaths = array(); //paths used for searching for extensions
    public $Interface = null;

    public $FileExtensionsToBeIgnored = ["jpg"]; //file extensions to be ignored when scanning for extensions

    //constructor method
    function __construct(array $searchPaths = [], string $interface = "") {
        
        if($searchPaths != null){
            $this->SearchPaths = $searchPaths;
        }

        if($interface != null){
            $this->Interface = $interface;
        }
    
    }

    //returns a list of all files inside a given search path
    public function GetPlugins(array $paths = null, string $interface = null, array $metadata = null):array {

        //set the (default) search paths, if no path(s) is/are given
        if($paths == null) {
            $paths = $this->SearchPaths;
        }

        //set the (default) interface, if none given
        if($interface == null) {
            $interface = $this->Interface;
        }

        //create a list of all classes found in all files found
        $output = array();

        foreach($paths as $path) {

            $folderInfo = new FolderInfo($path);

            foreach($folderInfo->files as $fileInfo) {

                if(!in_array($fileInfo->extension,$this->FileExtensionsToBeIgnored)){
                    
                    foreach($fileInfo->classes as $class){
                        $output[] = $class;
                    }

                }

            }

        }

        //validate the classes listed
        foreach($output as $index=>$extension){

            if($extension->ImplementsInterface($interface) != true){ //remove the class if not implementing the interface given
                unset($output[$index]);
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

}

?>