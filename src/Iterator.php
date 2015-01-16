<?php
namespace qtil {
    use restructr\Traits\ArrayIterator;
    
    trait Iterator {
        protected $position = 0;
        
        public function current() {
            $property = defined('static::$DOMAIN_PROPERTY') ? static::$DOMAIN_PROPERTY : 'data';
            $index = array_keys($this->{$property})[$this->position];
            return $this->{$property}[$index];
        }
        
        public function key() {
            $property = defined('static::$DOMAIN_PROPERTY') ? static::$DOMAIN_PROPERTY : 'data';
            return array_keys($this->{$property})[$this->position];
        }
        
        public function next() {
            ++$this->position;
        }
        
        public function rewind() {
            $this->position = 0;
        }
        
        public function valid() {
            $property = defined('static::$DOMAIN_PROPERTY') ? static::$DOMAIN_PROPERTY : 'data';
            return isset(array_keys($this->{$property})[$this->position]);
        }
    }
}