<?php
namespace qtil\Identifier {
    abstract class Scheme {
        protected $options;
        protected $identifyCallback;
        
        function __construct($options=[],$identifyCallback=null) {
            $this->options = (array)$options;
            $this->identifyCallback = $identifyCallback;
        }
        abstract function applies($object);
        function getIdentity($object) {
            $identifyCallback = $this->identifyCallback;
            
            if(is_callable($identifyCallback)) {
                return $identifyCallback($object);
            } elseif(
                is_string($identifyCallback) &&
                method_exists($object,$identifyCallback)
            ) {
                return $object->$identifyCallback();
            }
        }
    }
}
