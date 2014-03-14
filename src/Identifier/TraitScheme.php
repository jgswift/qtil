<?php
namespace qtil\Identifier {
    use qtil;
    /**
     * Trait scheme
     * @package qtil
     */
    class TraitScheme extends Scheme {
        /**
         * @param mixed $object
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
