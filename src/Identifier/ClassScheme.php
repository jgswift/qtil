<?php
namespace qtil\Identifier {
    /**
     * Class scheme
     * @package qtil
     */
    class ClassScheme extends Scheme {
        /**
         * Checks if object meets identification criteria
         * @param mixed $object
         * @return boolean
         */
        function applies($object) {
            $objectClass = get_class($object);
            
            return in_array($objectClass,$this->options);
        }
    }
}
