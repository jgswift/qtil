<?php
namespace qtil {
    trait ObjectAccess {
        use ArrayEnumerable;
        
        /**
         * Checks if local access list holds an item at given offset
         * @param mixed $offset
         * @return boolean
         */
        public function __isset($offset) {
            if(!is_int($offset) && !is_string($offset)) {
                return false;
            }
            
            $property = defined('static::$DOMAIN_PROPERTY') ? static::$DOMAIN_PROPERTY : 'data';
            if(!isset($this->{$property})) {
                $this->{$property} = [];
            }
            
            return array_key_exists($offset, $this->{$property});
        }

        /**
         * Retrieves item from local access list at given offset
         * @param mixed $offset
         * @return mixed
         */
        public function &__get($offset) {
            if($this->__isset($offset)) {
                $property = defined('static::$DOMAIN_PROPERTY') ? static::$DOMAIN_PROPERTY : 'data';
                return $this->{$property}[$offset];
            }

            $none = null;
            return $none;
        }

        /**
         * Sets value of item in local access list at given offset
         * @param mixed $offset
         * @param mixed $value
         */
        public function __set($offset, $value) {
            $property = defined('static::$DOMAIN_PROPERTY') ? static::$DOMAIN_PROPERTY : 'data';
            if(!isset($this->{$property})) {
                $this->{$property} = [];
            }
            
            $this->{$property}[$offset] = $value;
        }

        /**
         * Removes item in local access list at given offset
         * @param mixed $offset
         */
        public function __unset($offset) {
            $property = defined('static::$DOMAIN_PROPERTY') ? static::$DOMAIN_PROPERTY : 'data';
            unset($this->{$property}[$offset]);
        }
    }
}