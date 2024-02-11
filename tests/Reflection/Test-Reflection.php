<?php
//set namespace
namespace BytesPhp\Tests\Reflection;

//setup error displaying
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//import class(es) required
use BytesPhp\Reflection\ClassMetadata as Metadata;
use BytesPhp\Reflection\Extensibility\Extension as Extension;
use BytesPhp\Reflection\Extensibility\ExtensionsManager as ExtensionsManager;

require_once(__DIR__.'/../../vendor/autoload.php');

require_once(__DIR__.'/Test-Classes.php'); //add custom test class(es); required for this testing sceanrio, not for productive use

//test the metadata class: get 'SampleOne' metadata from type string
echo("<strong>Metadata for type 'SampleOne' from type string:</strong><br />");
$meta = new Metadata("BytesPhp\Tests\Reflection\SampleOne");

$keys = $meta->Keys();

foreach($keys as $key){
    echo($key.": ".$meta->$key."<br />");
}

echo("<br />");

//test the extension class: get 'Extension' class instance for 'AdditionExtension' type
echo("<strong>Metadata for 'AdditionExtension' from 'Extension' instance</strong><br />");
$extension = new Extension(__DIR__."/Test-Classes.php","BytesPhp\Tests\Reflection\AdditionExtension");

echo("File path: ". $extension->filePath."<br />");
echo("Class type name: ". $extension->className."<br />");
echo("Interface(s) implemented: ". implode("|",$extension->interfaces)."<br />");
echo("Metadata 'Name': ". $extension->metadata->name."<br />");

echo("<br />");

//test the extensions manager class: get all 'CalculatorExtension' extensions using the 'ExtensionsManager'
echo("<strong>All 'CalculatorExtension' 'Extension' instances using the 'ExtensionsManager'</strong><br />");
$manager = new ExtensionsManager();

//$extensions = $manager->GetExtensions(array(__DIR__."/Test-Classes.php")); //returns all extenions in a file; will result in a "method not found" exeption since not all classes implement the interface
$extensions = $manager->GetExtensions(array(__DIR__),"BytesPhp\Tests\Reflection\CalculatorExtension");
//$extensions = $manager->GetExtensions(array(__DIR__),"BytesPhp\Tests\Reflection\CalculatorExtension",array("name" => null)); //all extensions with the respective metadata value are allowed
//$extensions = $manager->GetExtensions(array(__DIR__),"BytesPhp\Tests\Reflection\CalculatorExtension",array("name" => "Addition")); //only a specific metdata value is allowed

foreach($extensions as $extension){
    echo("Class type name: ". $extension->className." calculates ".$extension->instance->Calculate(5,3)."<br />");
}
?>