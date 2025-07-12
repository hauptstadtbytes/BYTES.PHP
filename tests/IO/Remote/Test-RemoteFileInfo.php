<?php
//set namespace
namespace BytesPhp\Tests;

//setup error displaying
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//import class(es) and namespace(s) required
require_once(__DIR__.'/../../../vendor/autoload.php');

//import framework namespace(s) required
use BytesPhp\IO\Remote\RemoteFileInfo as RemoteFileInfo;
use BytesPhp\IO\FolderInfo as FolderInfo;

//check for a working URL
$url = "https://backup.mitpflegeleben.de/wp-content/uploads/2021/03/2021-03-23-premium-bonus-angebot-a4.pdf";

$remoteFile = new RemoteFileInfo($url);

//echo("URL '".$remoteFile->url."' exists: ".$remoteFile->exists."<br />\n");

//check for a non-working URL
$remoteFile = new RemoteFileInfo($url."abc.pdf");

//echo("URL '".$remoteFile->url."' exists: ".$remoteFile->exists."<br />\n");

//download the remote file
$remoteFile = new RemoteFileInfo($url);

$destDir = __DIR__."/../../Data/RemoteFiles";
$folder = new FolderInfo($destDir);

if($folder->exists) {
    $folder->Remove(true);
    echo("Folder '".$folder->path."' cleared<br />\n");
}

$remoteFile->Download($destDir."/ABC.pdf");

echo("File '".$remoteFile->name."' downloaded succesfully from '".$remoteFile->url."'<br />\n");
?>