<?php
namespace qtil {
    trait Serializable {
        /**
         * standard serializable serialize method
         * @return string
         */
        function serialize() {
            $property = defined('static::$DOMAIN_PROPERTY') ? static::$DOMAIN_PROPERTY : 'data';
            if(!isset($this->{$property})) {
                $this->{$property} = [];
            }
            
            return \serialize($this->{$property});
        }
        
        /**
         * standard serializable unserialize method
         * @param string $data
         */
        function unserialize($data) {
            $property = defined('static::$DOMAIN_PROPERTY') ? static::$DOMAIN_PROPERTY : 'data';
            $this->{$property} = \unserialize($data);
        }
    }
}