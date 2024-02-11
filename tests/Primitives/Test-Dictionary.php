<?php
//set namespace
namespace BytesPhp\Tests;

//setup error displaying
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//import class(es) required
use BytesPhp\Primitives\Dictionary as Dictionary;

require_once(__DIR__.'/../../vendor/autoload.php');

//create a set of sample data
$sampleData = array("one" => "red", "two" => "yellow", "three" => "pink", "four" => "green");

//create the dictionary
$dic = new Dictionary($sampleData);
$dic->five = "orange"; //add an additional item

//dump all values
var_dump($dic->Pairs());
echo("<br /><br />");

//iterate through all colors
$keys = $dic->Keys();

echo("<strong>Our rainbow consists of ".count($keys)." colors:</strong><br />");

foreach($keys as $key){
    echo($dic->$key."<br />");
}

//check for a specific key
echo("...and it contains the key 'five': ".$dic->ContainsKey("five")."<br /><br />");

//create a dictionary with default values
$animalDic = new Dictionary(null,["dog" => "Waldi", "cat" => "Mitzie", "bird" =>"","fish" =>""]);
//$animalDic = new Dictionary(null,["dog" => "Waldi", "cat" => "Mitzie", "bird" =>"","fish" =>""],false); //make the dictionary case-sensitive

//dump all values
var_dump($animalDic->Pairs());
echo("<br /><br />");

echo("<strong>The following animals are known:</strong><br />");
foreach($animalDic->Keys() as $key){
    echo($key.": ".$animalDic->$key."<br />");
}

echo("<br />");

//load additional data
$animalDic->Load(["Fish" => "Blub"]);

foreach($animalDic->Keys() as $key){
    echo($key.": ".$animalDic->$key."<br />");
}
?>