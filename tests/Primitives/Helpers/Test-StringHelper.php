<?php
//set namespace
namespace BytesPhp\Tests;

//setup error displaying
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//import class(es) required
use BytesPhp\Primitives\Helpers\StringHelper as Helper;

require_once(__DIR__.'/../../../vendor/autoload.php');

$data = "Hello World!";

echo("'".$data."' starts with 'Hello' (case-sensitive): ".Helper::StartsWith($data,"Hello",true)."<br />");
echo("'".$data."' starts with 'hello' (case-sensitive): ".Helper::StartsWith($data,"hello",true)."<br />");
echo("'".$data."' starts with 'hello' (case-insensitive): ".Helper::StartsWith($data,"hello")."<br />");
echo("'".$data."' starts with 'something' (case-insensitive): ".Helper::StartsWith($data,"something")."<br />");

echo("<br />");

echo("'".$data."' starts with 'Hello World !' (case-insensitive): ".Helper::StartsWith($data,"Hello World !")."<br />");
echo("'".$data."' starts with '' (case-insensitive): ".Helper::StartsWith($data,"")."<br />");

echo("<br />");

echo("'".$data."' ends with 'World!' (case-sensitive): ".Helper::EndsWith($data,"World!",true)."<br />");
echo("'".$data."' ends with 'world!' (case-sensitive): ".Helper::EndsWith($data,"world!",true)."<br />");
echo("'".$data."' ends with 'world!' (case-insensitive): ".Helper::EndsWith($data,"world!")."<br />");
echo("'".$data."' ends with 'something' (case-insensitive): ".Helper::EndsWith($data,"something")."<br />");

echo("<br />");

echo("'".$data."' ends with 'Hello another World!' (case-insensitive): ".Helper::EndsWith($data,"Hello another World!")."<br />");
echo("'".$data."' ends with '' (case-insensitive): ".Helper::EndsWith($data,"")."<br />");

echo("<br />");

echo("'".$data."' contains 'World' (case-sensitive): ".Helper::Contains($data,"World",true)."<br />");
echo("'".$data."' contains 'world' (case-insensitive): ".Helper::Contains($data,"world")."<br />");

echo("<br />");

echo("'".$data."' contains 'something' (case-insensitive): ".Helper::Contains($data,"something")."<br />");
echo("'".$data."' contains '' (case-insensitive): ".Helper::Contains($data,"")."<br />");
?>