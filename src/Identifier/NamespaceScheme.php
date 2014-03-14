<?php
namespace qtil\Identifier {
    /**
     * Namespace scheme
     * @package qtil
     */
    class NamespaceScheme extends Scheme {
        /**
         * Checks if object meets identification criteria
         * @param object $object
         * @return boolean
         */
        function applies($object) {
            $objectClass = get_class($object);
            
            if(!empty($this->options)) {
                foreach($this->options as $option) {
                    if(strpos($objectClass,$option) !== false) {
                        return true;
                    }
                }
            }
            
            return false;
        }
    }
}
