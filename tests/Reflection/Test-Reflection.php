<?php
//set namespace
namespace BytesPhp\Tests\Reflection;

//setup error displaying
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//import class(es) required
use BytesPhp\IO\FileInfo as FileInfo;

use BytesPhp\Reflection\ClassInfo as ClassInfo;
use BytesPhp\Reflection\ClassMetadata as ClassMetadata;

require_once(__DIR__.'/../../vendor/autoload.php');

require_once(__DIR__.'/Test-Classes.php'); //add custom test class(es); required for this testing sceanrio, not for productive use

//get all classes inside the 'Test-Classes.php' file
$fileInfo = new FileInfo(__DIR__.'/Test-Classes.php');

foreach($fileInfo->Classes as $class) {
    echo("Class <strong>".$class->name."</strong> found in file ".$class->file->path." with metadata");

    //return the metadata
    echo("<div style=\"text-indent:30px;\"><ul>");
    foreach($class->metadata->keys() as $key){
        echo("<li>".$key.": ".$class->metadata->$key."</li>");
    }
    echo("</ul></div>");

    //return the interface(s)
    echo("implements");

    $interfaces = $class->interfaces;

    if(count($interfaces) > 0){
        echo("<div style=\"text-indent:30px;\"><ul>");
            foreach($class->interfaces as $interface){
                echo("<li>".$interface."</li>");
            }
    echo("</ul></div>");
    } else {
        echo(" no interfaces<br /><br />");
    }

    //return calculation result
    if($class->ImplementsInterface("BytesPhp\Tests\Reflection\CalculatorExtension")){
        echo("The calculation result of '3' and '2' is ".$class->instance->Calculate(3,2)."<br /><br />");
    }
}
echo("<br />");
?>