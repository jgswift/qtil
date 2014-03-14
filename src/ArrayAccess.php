<?php
namespace qtil {
    trait ArrayAccess {
        /**
         * Checkes if item exists in access property list
         * @param mixed $offset
         * @return boolean
         */
        function offsetExists($offset) {
            if(!is_int($offset) && !is_string($offset)) {
                return false;
            }
            
            $property = Access\Registry::getAccessProperty($this);
            return array_key_exists($offset, $this->{$property});
        }

        /**
         * Retrieves item from access property list
         * @param mixed $offset
         * @return mixed
         */
        function offsetGet($offset) {
            $property = Access\Registry::getAccessProperty($this);
            if(!isset($this->{$property})) {
                $this->{$property} = [];
            }

            if(is_array($this->{$property}) && isset($this->{$property}[$offset])) {
                return $this->{$property}[$offset];
            }

            return null;
        }

        /**
         * Mutates data in access property list
         * @param mixed $offset
         * @param mixed $value
         */
        function offsetSet($offset, $value) {
            $property = Access\Registry::getAccessProperty($this);
            if(!isset($this->{$property})) {
                $this->{$property} = [];
            }

            $this->{$property}[$offset] = $value;
        }

        /**
         * Removes data from access property list
         * @param mixed $offset
         */
        function offsetUnset($offset) {
            $property = Access\Registry::getAccessProperty($this);
            unset($this->{$property}[$offset]);
        }
    }
}