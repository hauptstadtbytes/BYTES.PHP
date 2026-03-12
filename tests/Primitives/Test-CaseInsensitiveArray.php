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

echo($array["say"]."<br \>\n");
echo($array["SAY"]."<br \>\n");
echo($array["answer"]." ".$array[42]."<br \>\n");

$array["say"] = "Bye, bye!";
echo($array["say"]."<br \>\n");
?>