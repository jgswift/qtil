<?php
namespace qtil {
    trait Iterator {
        /**
         * standard iterator rewind method
         */
        function rewind() {
            Iterator\Registry::setIteratorPosition($this, 0);
        }
        
        /**
         * standard iterator current method
         * @return mixed
         */
        function current() {
            $position = Iterator\Registry::getIteratorPosition($this);
            
            $property = Access\Registry::getAccessProperty($this);
            
            return $this->{$property}[$position];
        }
        
        /**
         * standard iterator key method
         * @return integer
         */
        function key() {
            return Iterator\Registry::getIteratorPosition($this);
        }
        
        /**
         * standard iterator next method
         */
        function next() {
            Iterator\Registry::incrementIteratorPosition($this);
        }
        
        /**
         * standard iterator valid method
         * @return boolean
         */
        function valid() {
            $position = Iterator\Registry::getIteratorPosition($this);
            
            $property = Access\Registry::getAccessProperty($this);
            
            return array_key_exists($position,$this->{$property});
        }
    }
}