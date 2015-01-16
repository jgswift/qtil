<?php
namespace qtil {
    trait Countable {

        /**
         * Implements the \Countable interface
         * @return integer
         */
        public function count() {
            $property = defined('static::$DOMAIN_PROPERTY') ? static::$DOMAIN_PROPERTY : 'data';
            if(isset($this->{$property}) && 
                (   is_array($this->{$property}) ||
                    $this->{$property} instanceof \Countable)
                ) {
                return count($this->{$property});
               }
            
            return 0;
        }
    }
}