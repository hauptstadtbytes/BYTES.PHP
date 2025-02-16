<?php
//set namespace
namespace BytesPhp\Tests\Reflection\Extensibility;

//setup error displaying
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//import class(es) required
use BytesPhp\Reflection\Extensibility\Extensible as Extensible;

require_once(__DIR__.'/../../../vendor/autoload.php');

class MyResponder extends Extensible{

    public function WhoAreYou(){
        return "I am Fred, the original class instance";
    }

}

class MyResponderExtension{

    public static function AreYouAnExtension(MyResponder $responder) {
        return "Yes, this message comes from the extension class";
    }

    public static function WriteCustomMessage(MyResponder $responder, array $args) {

        foreach($args as $arg) {
            echo($arg."<br />");
        }

        echo("<strong>First arg message: ".$args[0]."</strong><br />");

        return;
    }

}

$responder = new MyResponder();

echo($responder->WhoAreYou()."<br /><br />");
echo($responder->AreYouAnExtension()."<br /><br />");
echo($responder->WriteCustomMessage("This extension message returns 'Hello World!'","Another message")."<br />");
?>