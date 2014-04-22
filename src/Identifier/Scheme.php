<?php
namespace qtil\Identifier {
    /**
     * Scheme class
     * @package qtil
     */
    abstract class Scheme {
        /**
         * List of scheme options
         * @var array
         */
        protected $options;
        
        /**
         * Callback for delegate identification
         * @var closure
         */
        protected $identifyCallback;
        
        /**
         * Default scheme constructor
         * @param array $options
         * @param callable $identifyCallback
         */
        function __construct($options=[],$identifyCallback=null) {
            $this->options = (array)$options;
            $this->identifyCallback = $identifyCallback;
        }
        
        /**
         * Checks if object meets identification criteria
         * @param mixed $object
         * @return boolean
         */
        abstract function applies($object);
        
        /**
         * Default method for identity retrieval
         * @param mixed $object
         * @return string
         */
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
