<?php
//set the namespace
namespace BytesPhp\IO;

//import internal namespace(s) required
use BytesPhp\Reflection\ClassInfo as ClassInfo;

//the 'FileInfo' class
class FileInfo{

    //protected variable(s)
    protected ?string $path = null;

    //constructor method
    function __construct(string $path) {

        $this->path = $path;
    }

    //(public) getter (magic) method, for read-only properties
    public function __get(string $property) {
            
        switch(strtolower($property)) {

            case "path":
                return $this->path;
                break;

            case "exists":
                return file_exists($this->path);
                break;

            case "parent":
                return new FolderInfo(dirname($this->path));
                break;

            case "classes":
                return $this->GetClasses();
                break;
            
            case "extension":
                return pathinfo($this->path, PATHINFO_EXTENSION);
                break;

            default:
                return null;
            
        }
        
    }

    //returns a list of all classes found
    private function GetClasses() {

        $output = [];

        if($this->exists) { //check if the file exists

            //read the file and get all token(s)
            //based on the article found at 'http://wiki.birth-online.de/snippets/php/get-classes-in-file'
            $tokens = token_get_all(file_get_contents($this->path));
            $namespace = "";

            //iterate over tokens
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
                    $output[] = new ClassInfo($this->path,$namespace.'\\'.$tokens[$index][1]);
            
                }

            }

        }

        return $output;

    }

}
?>