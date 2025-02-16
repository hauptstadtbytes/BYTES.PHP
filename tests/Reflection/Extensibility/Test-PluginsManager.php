<?php
//set namespace
namespace BytesPhp\Tests\Reflection\Extensibility;

//setup error displaying
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//import class(es) required
use BytesPhp\Reflection\Extensibility\PluginsManager as PluginsManager;

require_once(__DIR__.'/../../../vendor/autoload.php');

require_once(__DIR__.'/../Test-Classes.php'); //add custom test class(es); required for this testing sceanrio, not for productive use

//test the extensions manager class: get all 'CalculatorExtension' extensions using the 'ExtensionsManager'
echo("All <strong>BytesPhp\Tests\Reflection\CalculatorExtension</strong> extensions found by plugin manager:<br />");
$manager = new PluginsManager();

$extensions = $manager->GetPlugins(array(__DIR__."/.."),"BytesPhp\Tests\Reflection\CalculatorExtension");
//$extensions = $manager->GetPlugins(array(__DIR__),"BytesPhp\Tests\Reflection\CalculatorExtension",array("version" => null)); //all extensions with the respective metadata key are allowed
//$extensions = $manager->GetPlugins(array(__DIR__),"BytesPhp\Tests\Reflection\CalculatorExtension",array("name" => "Addition")); //only a specific metdata value is allowed

foreach($extensions as $extension){
    echo("extension class ".$extension->name." calculated for '5' and '3' the result ".$extension->instance->Calculate(5,3)."<br />");
}
?>