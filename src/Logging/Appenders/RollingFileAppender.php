<?php
//set the namespace
namespace BytesPhp\Logging\Appenders;

//import internal namespace(s) required
use BytesPhp\Logging\API\ILogAppender as ILogAppender;

use BytesPhp\Logging\LogEntry as LogEntry;

//the rolling file appender class
class RollingFileAppender Implements ILogAppender{

    //protected variable(s)
    protected ?string $folderPath = null;

    //public variable(s)
    public string $LineTemplate = "{Year}-{Month}-{Day} {Hour}:{Minute}:{Second};{Level};{Message};{Details}\n";
    public string $FileName = "{Year}-{Month}-{Day}.Log";

    //constructor method
    function __construct(string $folder) {

        $this->folderPath = $folder;
    }

    //implement 'ILogAppender', appending the log entry to disk file
    public function Append(LogEntry $entry) {

        //prepare the data
        $masks = $this->GetMasks($entry);

        $fileName = $this->ParseTemplate($this->FileName,$masks);
        $filePath = $this->folderPath.DIRECTORY_SEPARATOR.$fileName;

        //write to log file
        $logFile = fopen($filePath,"a") or die("Unable to open file at ".$filePath);
        fwrite($logFile,$this->ParseTemplate($this->LineTemplate,$masks));
        fclose($logFile);

    }

    //returns the list of masks that might be used in the template(s)
    private function GetMasks(LogEntry $entry):array {

        $output = ["{Year}" => $entry->timestamp->format('Y'),"{Month}" => $entry->timestamp->format('m'), "{Day}" => $entry->timestamp->format('d'), "{Hour}" => $entry->timestamp->format('H'), "{Minute}" => $entry->timestamp->format('i'), "{Second}" => $entry->timestamp->format('s')];

        $output["{Level}"] = $entry->level->name;
        $output["{Message}"] = $entry->message;

        ob_start();
        var_dump($entry->details);
        $output["{Details}"] = ob_get_clean();

        return $output;

    }

    //parse the template string
    private function ParseTemplate(string $template, array $masks):string {

        $output = $template;

        foreach($masks as $mask => $value) {
            $output = str_replace($mask,$value,$output);
        }

        return $output;
    }

}

?>