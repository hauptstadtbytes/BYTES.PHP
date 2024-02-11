<?php

//set the namespace
namespace BytesPhp\IO\Helpers;

class IOHelper{

    static function FolderExtists($folder) : bool{

        // Get canonicalized absolute pathname
        $path = realpath($folder);

        // If it exist, check if it's a directory
        if($path !== false AND is_dir($path))
        {
            return true;
        }

        // Path/folder does not exist
        return false;
    }

    //method returning a list of all files found inside given search path(s)
    static function Files(array $paths):array {

        $output = array();

        foreach($paths as $path) { //loop for each path found

            if(static::FolderExtists($path)){ //check if the given path points to a (really exising) directory

                //call method recursively for each file and folder inside the directory
                //based on the article found at 'http://www.php.net/manual/de/function.scandir.php'
                foreach(scandir($path) as $objectKey => $objectValue){

                    if(!in_array($objectValue,array(".",".."))) { //ignore default file system objects
            
                        $output = array_merge($output,self::Files(array($path.DIRECTORY_SEPARATOR.$objectValue)));
                        
                    }
                }

            } else { //continue for a file path

                if(is_file($path)) {

                    $output[] = $path;
                    
                }
                
            }

        }

        return $output;

    }

}
?>