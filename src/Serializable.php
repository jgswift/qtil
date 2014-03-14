<?php
namespace qtil {
    trait Serializable {
        /**
         * standard serializable serialize method
         * @return string
         */
        function serialize() {
            $property = Access\Registry::getAccessProperty($this);
            return \serialize($this->{$property});
        }
        
        /**
         * standard serializable unserialize method
         * @param string $data
         */
        function unserialize($data) {
            $property = Access\Registry::getAccessProperty($this);
            $this->{$property} = \unserialize($data);
        }
    }
}