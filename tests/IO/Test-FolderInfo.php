<?php
//set namespace
namespace BytesPhp\Tests;

//setup error displaying
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//import class(es) and namespace(s) required
require_once(__DIR__.'/../../vendor/autoload.php');
//require_once(__DIR__.'/../../src/IO/FolderInfo.php');
//require_once(__DIR__.'/../../src/IO/FileInfo.php');

//import framework namespace(s) required
use BytesPhp\IO\FolderInfo as FolderInfo;
use BytesPhp\IO\FileInfo as FileInfo;

class FileInfoExtension{

    public static function CreationDate(FileInfo $file) {
        return date('Y-m-d H:i:s',$file->created);
    }

    public static function ModificationDate(FileInfo $file) {
        return date('Y-m-d H:i:s',$file->modified);
    }

    //creates a new file
    public static function Create(FileInfo $file){
        $myFile = fopen($file->path,"a") or die("Unable to open file at ".$this->filePath);
        fwrite($myFile,"Sample content in a sample file\n");
        fclose($myFile);
    }

}

class FolderInfoExtension{

    public static function CreationDate(FolderInfo $folder) {
        return date('Y-m-d H:i:s',$folder->created);
    }

    public static function ModificationDate(FolderInfo $folder) {
        return date('Y-m-d H:i:s',$folder->modified);
    }

    //echos all subfolders found
    public static function EchoSubfolders(FolderInfo $folder) {

        foreach($folder->folders as $subfolderInfo) {
            echo("Folder (created at ".$subfolderInfo->CreationDate().", modified at ".$subfolderInfo->ModificationDate().") found at ". $subfolderInfo->path."<br />");
        }
        echo("<br />");

    }

    //creates a new folder
    public static function Create(FolderInfo $folder){
        if(!$folder->exists){
            mkdir($folder->path);
        }
    }

}

//create the folder infor class
$folderInfo = new FolderInfo(__DIR__."/../Reflection");

//check for the path
echo("Folder path ".$folderInfo->path." exists");

if($folderInfo->exists != true) {
    echo(" not");
}
echo("<br /><br />");

//list all files
foreach($folderInfo->files as $fileInfo){
    echo("File with extension ".$fileInfo->extension."(created at ".$fileInfo->CreationDate().", modified at ".$fileInfo->ModificationDate().") found at ". $fileInfo->path." in folder ".$fileInfo->parent->path."<br />");
}
echo("<br />");

//show the parent folder path
$parentFolderInfo = $folderInfo->parent;

if(!is_null($parentFolderInfo)) {

    echo("Parent folder path: ".$parentFolderInfo->path."<br /><br />");

    //add a test folder
    $newFolder = new FolderInfo($parentFolderInfo->path.DIRECTORY_SEPARATOR."RuntimeTest");
    $newFolder->Create();

    //add a test file
    $newFile = new FileInfo($newFolder->path.DIRECTORY_SEPARATOR."RuntimeFile");
    $newFile->Create();

    //list all folders
    $parentFolderInfo->EchoSubfolders($parentFolderInfo);

    //delete the runtinme folder
    $newFolder->Remove(true); //deletes also the non-empty folder
    //$newFolder->Remove(); //delete only if empty (results in a warning in testing scenario)
    echo("== The runtime folder sould not be listed any more == <br />");
    $parentFolderInfo->EchoSubfolders($parentFolderInfo);

}
?>