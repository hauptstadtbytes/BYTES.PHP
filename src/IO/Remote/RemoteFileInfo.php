<?php

//set the namespace
namespace BytesPhp\IO\Remote;

//import internal namespace(s) required
use BytesPhp\Reflection\Extensibility\Extensible as Extensible;

use BytesPhp\IO\FolderInfo as FolderInfo;
use BytesPhp\IO\FileInfo as FileInfo;

//the 'RemoteFileInfo' class
class RemoteFileInfo extends Extensible{

    //protected variable(s)
    protected ?string $url = null;

    //constructor method
    function __construct(string $url) {

        $this->url = $url;
    }

    //(public) getter (magic) method, for read-only properties
    public function __get(string $property) {
            
        switch(strtolower($property)) {

            case "url":
                return $this->url;
                break;

            case "name":
                return basename($this->url);
                break;

            case "exists":
                return $this->CheckFileExists();
                break;

            case "extension":
                return pathinfo($this->path, PATHINFO_EXTENSION);
                break;

            default:
                return null;
            
        }
        
    }

    //public function downloading the file from remote location
    public function Download(string $localPath) {

        //parse the argument(s)
        $folderInfo = new FolderInfo(dirname($localPath));

        //check for the output directory (and create if required)
        if(!$folderInfo->exists) {
            $folderInfo->Create();
        }

        //download the file
        file_put_contents($localPath, fopen($this->url, 'r'));

    }

    //private function, checking if an URL (file) exists
    private function CheckFileExists(): bool {

        if(strpos(get_headers($this->url)[0],"200")) { //check for the '200' HTTP status code

            return true;

        }

        return false;
    }

}

?>