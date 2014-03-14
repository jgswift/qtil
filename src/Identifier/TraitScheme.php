<?php
namespace qtil\Identifier {
    use qtil;
    /**
     * Trait scheme
     * @package qtil
     */
    class TraitScheme extends Scheme {
        /**
         * Checks if object meets identification criteria
         * @param object $object
         * @return boolean
         */
        function applies($object) {
            if(!empty($this->options)) {
                return qtil\ReflectorUtil::classUses($object,$this->options);
            }
            
            return false;
        }
    }
}
