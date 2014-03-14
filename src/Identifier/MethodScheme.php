<?php
namespace qtil\Identifier {
    class MethodScheme extends Scheme {
        function applies($object) {
            $methods = get_class_methods(get_class($object));
            
            $intersect = array_intersect($methods,$this->options);
            return !empty($intersect);
        }
        
        function getIdentity($object) {
            echo 'test';
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
