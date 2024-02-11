<?php
//set namespace
namespace BytesPhp\Tests;

//setup error displaying
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//import class(es) and namespace(s) required
require_once(__DIR__.'/../../../vendor/autoload.php');

use BytesPhp\IO\Helpers\IOHelper as IOHelper;

//get a list off all files
$files = IOHelper::Files(array(__DIR__."/../../Reflection"));

foreach($files as $file){
    echo("File: ". $file."<br />");
}

?>