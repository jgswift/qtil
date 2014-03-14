<?php
namespace qtil {
    trait Countable {

        /**
         * Implements the \Countable interface
         * @return integer
         */
        public function count() {
            $property = Access\Registry::getAccessProperty($this);
            return count($this->{$property});
        }
    }
}