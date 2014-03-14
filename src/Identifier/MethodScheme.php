<?php
namespace qtil\Identifier {
    /**
     * Method scheme
     * @package qtil
     */
    class MethodScheme extends Scheme {
        /**
         * Checks if object meets identification criteria
         * @param object $object
         * @return boolean
         */
        function applies($object) {
            $methods = get_class_methods(get_class($object));
            
            $intersect = array_intersect($methods,$this->options);
            return !empty($intersect);
        }
        
        /**
         * Identification by method
         * @param object $object
         * @return string
         * @throws \qtil\Exception
         */
        function getIdentity($object) {
            if(!empty($this->identifyCallback)) {
                return parent::getIdentity($object);
            }
            
            $methods = get_class_methods(get_class($object));
            
            $intersect = array_intersect($methods,$this->options);
            if(count($intersect) === 1) {
                $methodName = $intersect[0];
                return $object->$methodName();
            } else {
                throw new \qtil\Exception('Multiple methods found in identification scheme.');
            }
        }
    }
}
