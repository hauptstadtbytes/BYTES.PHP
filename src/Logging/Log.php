<?php
//set the namespace
namespace BytesPhp\Logging;

//import internal namespace(s) required
use BytesPhp\Logging\API\ILogAppender as ILogAppender;

use BytesPhp\Logging\InformationLevel as InformationLevel;
use BytesPhp\Logging\LogEntry as LogEntry;

//the log class
class Log{

    //private variable(s)
    private array $cache = [];
    private array $appenders = [];

    //public variable(s)
    public int $CacheLimit = 100;
    public InformationLevel $Threshold = InformationLevel::Info;

    //(public) getter (magic) method, for read-only properties
    public function __get(string $property) {
            
        switch(strtolower($property)) {

            case "cache":
                return $this->cache;
                break;

            default:
                return null;
            
        }
    }

    //registers a new appender
    public function RegisterAppender(ILogAppender $appender){
        $this->appenders[] = $appender;
    }

    //writes a new entry to the log
    public function Write(LogEntry $entry){

        if($entry->IsMoreImportant($this->Threshold)){ //validate the information level against the threshold

            //add the new entry to the local cache
            $this->cache[] = $entry;

            while(count($this->cache) > $this->CacheLimit) { //remove leading entries if cache size is over limit
                array_shift($this->cache);
            }

            //append the log entries
            foreach($this->appenders as $appender) {
                $appender->Append($entry);
            }

        }

    }

    //write to log using a specific information level
    public function Debug(string $message, $details = null) {
        $this->Write(new LogEntry($message, InformationLevel::Debug, $details));
    }

    public function Info(string $message, $details = null) {
        $this->Write(new LogEntry($message, InformationLevel::Info, $details));
    }

    public function Warning(string $message, $details = null) {
        $this->Write(new LogEntry($message, InformationLevel::Warning, $details));
    }

    public function Exception(string $message, $details = null) {
        $this->Write(new LogEntry($message, InformationLevel::Exception, $details));
    }

    public function Fatal(string $message, $details = null) {
        $this->Write(new LogEntry($message, InformationLevel::Fatal, $details));
    }

}
?>