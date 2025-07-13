<?php
//set namespace
namespace BytesPhp\Tests;

//setup error displaying
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__.'/../../../vendor/autoload.php');

//import framework namespace(s) requried
use BytesPhp\IO\FileInfo as FileInfo;
use BytesPhp\IO\FolderInfo as FolderInfo;

use BytesPhp\IO\Compression\FileInfoZIPExtension as FileInfoZIPExtension; //add the ZIP extension(s)
$extension = new FileInfoZIPExtension(); //initialize the ZIP extension(s)

//set the test parameter(s)
$sourceDir = __DIR__."/../../Reflection";
$dataDir = new FolderInfo(__DIR__."/../../Data/Compression");

//clear the test space(s)
if($dataDir->exists) {
    $dataDir->Remove(true);
}

//add single file(s)
$srcFile = new FileInfo($sourceDir."/sampleDocument.pdf");

if($srcFile->ZIP($dataDir->path."/sampleArchive.zip")) {

    echo("File '".$srcFile->path."' added successfully to archive at '".$dataDir->path."/sampleArchive.zip"."'<br />\n");

} else {

    echo("Failed to add file '".$srcFile->path."'<br />\n");

}

$srcFile = new FileInfo($sourceDir."/sampleImage.jpg");

if($srcFile->ZIP($dataDir->path."/sampleArchive.zip",true)) {

    echo("File '".$srcFile->path."' appended successfully to archive at '".$dataDir->path."/sampleArchive.zip"."'<br />\n");

} else {

    echo("Failed to append file '".$srcFile->path."'<br />\n");

}

?>