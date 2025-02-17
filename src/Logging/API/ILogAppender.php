<?php
//set the namespace
namespace BytesPhp\Logging\API;

//import internal namespace(s) required
use BytesPhp\Logging\LogEntry as LogEntry;

//the entdpoint extension interface
interface ILogAppender {

    //writes the new log entry
    public function Append(LogEntry $entry);

}
?>