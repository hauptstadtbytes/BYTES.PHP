<?php
//set the namespace
namespace BytesPhp\Reflection\Extensibility;

//the extensible base class
//based on the article found at 'https://blog.maartenballiauw.be/post/2010/05/18/extension-methods-for-php.html'
class Extensible{

    public function __call($functionName, $arguments = array())
    {
        // Current reflected class
        $reflectedClass = new \ReflectionObject($this);

        // Find suitable class and function
        foreach (get_declared_classes() as $class) {

            $classDefinition = new \ReflectionClass($class);

            foreach ($classDefinition->getMethods() as $method) {

                if ($method->isStatic() && $method->getName() == $functionName) {

                    $availableParameters = $method->getParameters();

                    if ($availableParameters[0]->getType()->getName() == $reflectedClass->getName()) {

                        if(count($availableParameters) == 1) {
                            return $method->invoke(null, $this);
                        } else {
                            return $method->invokeArgs(null, [$this,$arguments]);
                        }
                        
                    }

                }

            }

        }
    } 

}
?>