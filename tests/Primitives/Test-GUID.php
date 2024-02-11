<?php
//set namespace
namespace BytesPhp\Tests;

//setup error displaying
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//import class(es) required
use BytesPhp\Primitives\GUID as GUID;

require_once(__DIR__.'/../../vendor/autoload.php');

echo(GUID::Create());
?>