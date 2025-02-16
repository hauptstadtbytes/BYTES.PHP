<?php
//set namespace
namespace BytesPhp\Tests;

//setup error displaying
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//import class(es) required
require_once(__DIR__.'/../../src/Primitives/String.php');

$data = "Hello World!";

echo("'".$data."' starts with 'Hello' (case-sensitive): ".string_startswith($data,"Hello",true)."<br />");
echo("'".$data."' starts with 'hello' (case-sensitive): ".string_startswith($data,"hello",true)."<br />");
echo("'".$data."' starts with 'hello' (case-insensitive): ".string_startswith($data,"hello")."<br />");
echo("'".$data."' starts with 'something' (case-insensitive): ".string_startswith($data,"something")."<br />");

echo("<br />");

echo("'".$data."' starts with 'Hello World !' (case-insensitive): ".string_startswith($data,"Hello World !")."<br />");
echo("'".$data."' starts with '' (case-insensitive): ".string_startswith($data,"")."<br />");

echo("<br />");

echo("'".$data."' ends with 'World!' (case-sensitive): ".string_endswith($data,"World!",true)."<br />");
echo("'".$data."' ends with 'world!' (case-sensitive): ".string_endswith($data,"world!",true)."<br />");
echo("'".$data."' ends with 'world!' (case-insensitive): ".string_endswith($data,"world!")."<br />");
echo("'".$data."' ends with 'something' (case-insensitive): ".string_endswith($data,"something")."<br />");

echo("<br />");

echo("'".$data."' ends with 'Hello another World!' (case-insensitive): ".string_endswith($data,"Hello another World!")."<br />");
echo("'".$data."' ends with '' (case-insensitive): ".string_endswith($data,"")."<br />");

echo("<br />");

echo("'".$data."' contains 'World' (case-sensitive): ".string_contains($data,"World",true)."<br />");
echo("'".$data."' contains 'world' (case-insensitive): ".string_contains($data,"world")."<br />");

echo("<br />");

echo("'".$data."' contains 'something' (case-insensitive): ".string_contains($data,"something")."<br />");
echo("'".$data."' contains '' (case-insensitive): ".string_contains($data,"")."<br />");
?>