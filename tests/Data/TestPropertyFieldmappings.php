<?php
//set namespace
namespace BytesPhp\Tests\Data;

//setup error displaying
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//import class(es) required
use BytesPhp\Data\FieldPropertyMapping as FieldPropertyMapping;
use BytesPhp\Data\FieldPropertyMappingsList as FieldPropertyMappingsList;

require_once(__DIR__.'/../../vendor/autoload.php');

//create new mappings
$mappingOne = new FieldPropertyMapping("id", "idField");
$mappingTwo = new FieldPropertyMapping("title", "titleField");

$sourceList = [$mappingOne,new FieldPropertyMapping("content", "contentField")];

//get the mapping details
echo("<h1>Mappings Details</h1>");
echo("Property Name:".$mappingOne->PropertyName."<br />\n");
echo("Field Name:".$mappingOne->FieldName."<br />\n");

//create a new mappings list
$mappingList = new FieldPropertyMappingsList($sourceList);

//get all mappings by property name
echo("<h1>Mappings by Property Name</h1>");

foreach($mappingList->AsArrayByPropertyName as $key => $mapping) {
    echo("Index '".$key."' = '".$mapping->PropertyName." (property name) & '".$mapping->FieldName."' (field name)<br />\n");
}

//get all mappings by field name
echo("<h1>Mappings by Field Name</h1>");

foreach($mappingList->AsArrayByFieldName as $key => $mapping) {
    echo("Index '".$key."' = '".$mapping->PropertyName." (property name) & '".$mapping->FieldName."' (field name)<br />\n");
}

//add a mapping
echo("<h1>Mappings by Property Name</h1>");

$mappingList->Add($mappingTwo);
echo("Mapping for field '".$mappingTwo->FieldName."' added<br />\n<br />\n");

echo("<strong>All:</strong><br />\n");
foreach($mappingList->AsArrayByPropertyName as $mapping) {
    echo("Property: ".$mapping->PropertyName." - FieldName: ".$mapping->FieldName."<br />\n");
}

//echo("<br />\nTrying to add a property already listed:<br />\n");
//$mappingList->Add(new FieldPropertyMapping("id", "anotherIDField"));

echo("<br />\nTrying to add a field already listed:<br />\n");
$mappingList->Add(new FieldPropertyMapping("anotherProperty", "idField"));
?>