<?php
//set namespace
namespace BytesPhp\Tests;

//setup error displaying
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//import class(es) and namespace(s) required
require_once(__DIR__.'/../../vendor/autoload.php');

//import framework namespace(s) required
use BytesPhp\Logging\API\ILogAppender as ILogAppender;

use BytesPhp\Logging\Log as Log;
use BytesPhp\Logging\LogEntry as LogEntry;
use BytesPhp\Logging\InformationLevel as InformationLevel;

use BytesPhp\Logging\Appenders\RollingFileAppender as RollingFileAppender;

use BytesPhp\IO\FileInfo as FileInfo;

function EchoCache(Log $log) {

    echo("Cached log entries for threshold level <strong>".$log->Threshold->name."</strong><br />");

    foreach($log->Cache as $entry) {
        //echo($entry->timestamp->format('Y-m-d H:i:s').";".$entry->level->name.";".$entry->message."<br />");
        echo($entry->GetLine()."<br />");
    }

    echo("<br />");

}

class SimpleFileAppender Implements ILogAppender{

    private string $filePath = __DIR__.'/log.txt';

    //the function appending the log entry to file
    public function Append(LogEntry $entry) {

        $myFile = fopen($this->filePath,"a") or die("Unable to open file at ".$this->filePath);
        fwrite($myFile,$entry->GetLine()."\n");
        fclose($myFile);

    }

    //'LogEntry' extension method
    public static function GetLine(LogEntry $entry) {
        return $entry->timestamp->format('Y-m-d H:i:s').";".$entry->level->name.";".$entry->message;
    }

}

//create a new log
$myLog = new Log();

//add a new log entry
$myLog->Write(new LogEntry("my first log entry"));

EchoCache($myLog);

//add a new log entry not to be added
$myLog->Write(new LogEntry("my first log entry",InformationLevel::Debug));

echo("== The output from above shall not change ==<br />");
EchoCache($myLog);

//check the cache limit
$myLog->CacheLimit = 5;

for ($i = 1; $i <= 5; $i++) {
    $myLog->Write(new LogEntry("a new log entry #".$i));
}

echo("== There shall be only 5 '#' entries listed ==<br />");
EchoCache($myLog);

//add entries using the defined information levels
$myLog->Threshold = InformationLevel::Debug;

$myLog->Debug("This is a debugging message");
$myLog->Info("This is an informational message");
$myLog->Warning("This is a warning message");
$myLog->Exception("This is a exception message");
$myLog->Fatal("This is a fatal exception message");

echo("== There shall be 5 entries listed (one for each information level) ==<br />");
EchoCache($myLog);

//check for appending
$logFile = new FileInfo(__DIR__.'/log.txt');
$logFile->Remove(); //remove the file (if existing)

$myLog->RegisterAppender(new SimpleFileAppender());

$rollingFileAppender = new RollingFileAppender(__DIR__);
$rollingFileAppender->LineTemplate = "{Year}-{Month}-{Day} {Hour}:{Minute}:{Second};{Level};{Message}\n";
$rollingFileAppender->FileName = "{Year}-{Month}-{Day}-{Hour}-{Minute}.Log";
$myLog->RegisterAppender($rollingFileAppender );

for ($i = 1; $i <= 5; $i++) {
    $myLog->Info("a new log entry #".$i." that shall be written to log file");
}

if($logFile->exists) {
    echo("== The log file was found ==<br />");

    $handle = fopen(__DIR__.'/log.txt', "r");
    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            echo($line."<br />");
        }

        fclose($handle);
    }
} else {
    echo("== The log file was NOT found ==<br />");
}
?>