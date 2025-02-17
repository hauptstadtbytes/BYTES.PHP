<?php
//set the namespace
namespace BytesPhp\IO;

//import internal namespace(s) required
use BytesPhp\IO\FileInfo as FileInfo;

use BytesPhp\Reflection\Extensibility\Extensible as Extensible;

//the 'FolderInfo' class
class FolderInfo extends Extensible{

    //protected variable(s)
    protected ?string $path = null;

    //constructor method
    function __construct(string $path) {

        $this->path = realpath($path);

        //support non-existing folder paths
        if(strlen($this->path) == 0) {
            $this->path = $path; 
        }

    }

    //(public) getter (magic) method, for read-only properties
    public function __get(string $property) {
            
        switch(strtolower($property)) {

            case "path":
                return $this->path;
                break;

            case "exists":
                return is_dir($this->path);
                break;

            case "folders":
                return $this->GetSubfolders();
                break;

            case "files":
                return $this->GetFiles();
                break;

            case "parent":
                if($this->exists) {
                    return new FolderInfo(dirname($this->path));
                } else {
                    return null;
                }
                break;
            
            case "created":
                return filectime($this->path); //see 'https://stackoverflow.com/questions/6815964/php-get-create-time-of-directory' for details
                break;

            case "modified":
                return filemtime($this->path);
                break;

            default:
                return null;
            
        }
        
    }

    //deletes a file (if existing)
    public function Remove(bool $recusive = false, string $path = null){
        
        if(is_null($path)){
            $path = $this->path;
        }

        $info = new FolderInfo($path);

        if($info->exists) {

            if($recusive) { //based on the article found at 'https://www.php.net/manual/en/function.rmdir.php'

                $files = array_diff(scandir($path), array('.','..'));

                foreach ($files as $file) {

                    (is_dir($path.DIRECTORY_SEPARATOR.$file)) ? Remove($path.DIRECTORY_SEPARATOR.$file) : unlink($path.DIRECTORY_SEPARATOR.$file);

                }

                return rmdir($path);

            } else {

                //remove an empty directory
                return rmdir($path);

            }

        }

    }

    //returns a list of all subfolders
    private function GetSubfolders() {

        $output = [];

        foreach($this->GetFSObjects($this->path) as $path) {

            if(is_dir($path)){

                $output[] = new FolderInfo($path);

            }

        }

        return $output;

    }

    //returns a list of all files inside the given directory path
    private function GetFiles() {

        $output = [];

        foreach($this->GetFSObjects($this->path) as $path) {

            if(!is_dir($path)) {

                if(file_exists($path)){

                    $output[] = new FileInfo($path);
    
                }

            }

        }

        return $output;

    }

    //returns a list of all filesystem objects
    //based on the article found at 'https://www.php.net/manual/de/function.scandir.php'
    private function GetFSObjects(string $path, ?array $toBeIgnored = [".",".."]){

        $output = [];

        if(is_dir($path)) {

            foreach(scandir($path) as $objectKey => $objectValue){

                if(!in_array($objectValue,$toBeIgnored)) { //ignore (default file system) objects
        
                    $output[] = $path.DIRECTORY_SEPARATOR.$objectValue;
                    
                }
            }

        }

        return $output;

    }

}
?>