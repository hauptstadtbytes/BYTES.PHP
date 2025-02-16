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
    echo("File with extension ".$fileInfo->extension." found at ". $fileInfo->path." in folder ".$fileInfo->parent->path."<br />");
}
echo("<br />");

//show the parent folder path
$parentFolderInfo = $folderInfo->parent;

if(!is_null($parentFolderInfo)) {

    echo("Parent folder path: ".$parentFolderInfo->path."<br /><br />");

    //list all folders
    foreach($parentFolderInfo->folders as $subfolderInfo) {
        echo("Folder found at ". $subfolderInfo->path."<br />");
    }
    echo("<br />");

}
?>