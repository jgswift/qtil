<?php
namespace qtil\Identifier {
    /**
     * Property scheme
     * @package qtil
     */
    class PropertyScheme extends Scheme {
        /**
         * Checks if object meets identification criteria
         * @param mixed $object
         * @return boolean
         */
        function applies($object) {
            if(!empty($this->options)) {
                foreach($this->options as $option) {
                    if(property_exists($object,$option)) {
                        return true;
                    }
                }
            }
            
            return false;
        }
        
    }
}
