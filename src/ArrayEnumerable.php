<?php
namespace qtil {
    
    trait ArrayEnumerable {
        /**
         * Enumerable implementation with optional domain customization
         * @return array
         */
        public function &toArray() {
            $property = defined('static::$DOMAIN_PROPERTY') ? 
                    static::$DOMAIN_PROPERTY : 
                    ($this instanceof Interfaces\Collection) ? 
                        'items' : 
                        'data';
            
            return $this->{$property};
        }
    }
}