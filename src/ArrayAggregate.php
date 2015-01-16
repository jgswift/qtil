<?php
namespace qtil {
    trait ArrayAggregate {
        public function getIterator() {
            $property = defined('static::$DOMAIN_PROPERTY') ? static::$DOMAIN_PROPERTY : 'data';
            $iterator = isset(self::$ITERATOR_CLASS) ? self::$ITERATOR_CLASS : 'ArrayIterator';
            return new $iterator($this->{$property});
        }
    }
}