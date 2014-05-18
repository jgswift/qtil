<?php
namespace qtil {
    trait ObjectAccess {
        /**
         * Checks if local access list holds an item at given offset
         * @param mixed $offset
         * @return boolean
         */
        public function __isset($offset) {
            if(!is_int($offset) && !is_string($offset)) {
                return false;
            }
            
            $property = Access\Registry::getAccessProperty($this);
            return array_key_exists($offset, $this->{$property});
        }

        /**
         * Retrieves item from local access list at given offset
         * @param mixed $offset
         * @return mixed
         */
        public function &__get($offset) {
            if($this->__isset($offset)) {
                $property = Access\Registry::getAccessProperty($this);
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
            $property = Access\Registry::getAccessProperty($this);
            $this->{$property}[$offset] = $value;
        }

        /**
         * Removes item in local access list at given offset
         * @param mixed $offset
         */
        public function __unset($offset) {
            $property = Access\Registry::getAccessProperty($this);
            unset($this->{$property}[$offset]);
        }
    }
}