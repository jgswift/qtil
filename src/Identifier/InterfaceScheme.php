<?php
namespace qtil\Identifier {
    /**
     * Interface scheme
     * @package qtil
     */
    class InterfaceScheme extends Scheme {
        /**
         * Checks if object meets identification criteria
         * @param mixed $object
         * @return boolean
         */
        function applies($object) {
            if(!empty($this->options)) {
                foreach($this->options as $interface) {
                    if($object instanceof $interface) {
                        return true;
                    }
                }
            }
            
            return false;
        }
    }
}
