<?php
//set namespace
namespace BytesPhp\Tests;

//setup error displaying
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//import class(es) required
use BytesPhp\Primitives\CaseInsensitiveArray as CaseInsensitiveArray;

require_once(__DIR__.'/../../vendor/autoload.php');

$array = new CaseInsensitiveArray();
$array["say"] = "Hello!";
$array["answer"] = 42;
$array[42] = "is the answer";

echo("<h3>Echo values</h3>");
echo("say: ".$array["say"]."<br \>\n");
echo("SAY: ".$array["SAY"]."<br \>\n");
echo($array["answer"]." ".$array[42]."<br \>\n");

echo("<h3>Modify the 'say' key</h3>");
$array["say"] = "Bye, bye!";
echo($array["say"]."<br \>\n");

echo("<h3>Loop for each key value pair</h3>");
foreach($array as $key => $val) {
    echo($key.":".$val."<br \>\n");
}

echo("<h3>Loop for each key</h3>");
foreach($array->Keys() as $key) {
    echo($key."<br \>\n");
}

echo("<h3>Loop for each value</h3>");
foreach($array->Values() as $val) {
    echo($val."<br \>\n");
}
?>