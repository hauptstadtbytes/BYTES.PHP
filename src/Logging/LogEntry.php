<?php
//set the namespace
namespace BytesPhp\Logging;

//use global namespace(s)
use \DateTime as DateTime;

//import internal namespace(s) required
use BytesPhp\Logging\InformationLevel as InformationLevel;

use BytesPhp\Reflection\Extensibility\Extensible as Extensible;

//the log entry class
class LogEntry extends Extensible{

    //private variable(s)
    private DateTime $timestamp;
    private string $message;
    private InformationLevel $level;
    private $details;

    //constructor method
    function __construct(string $message, InformationLevel $level = InformationLevel::Info, $details = null) {

        $this->timestamp = new DateTime();

        $this->message = $message;
        $this->level = $level;
        $this->details = $details;

    }

    //(public) getter (magic) method, for read-only properties
    public function __get(string $property) {
            
        switch(strtolower($property)) {

            case "timestamp":
                return $this->timestamp;
                break;

            case "level":
                return $this->level;
                break;

            case "message":
                return $this->message;
                break;

            case "details":
                return $this->GetClasses();
                break;

            default:
                return null;
            
        }
        
    }

    //returns a boolean, indication wheather the information level is over the threshold or not
    public function IsMoreImportant(InformationLevel $threshold): bool {

        if($threshold === InformationLevel::Debug){ //return always 'true' for debug level thresholds
            return true;
        }

        if($threshold === InformationLevel::Info){

            if($this->level === InformationLevel::Debug) {
                return false;
            } else {
                return true;
            }

        }

        if($threshold === InformationLevel::Warning){

            if($this->level === InformationLevel::Debug) {
                return false;
            }

            if($this->level === InformationLevel::Info) {
                return false;
            }

            return true;
        }

        if($threshold === InformationLevel::Exception){

            if($this->level === InformationLevel::Fatal) {
                return true;
            }

            if($this->level === InformationLevel::Exception) {
                return true;
            }

            return false;
            
        }

        if($threshold === InformationLevel::Fatal){

            if($this->level === InformationLevel::Fatal) {
                return true;
            } else {
                return false;
            }

        }

    }
    
}
?>