<?php
namespace qtil\Chain {
    class ClassRegistry extends Registry {
        /**
         * Identifies passed objects by class and not object uid
         * @param mixed $object
         * @return string
         * @throws \InvalidArgumentException
         */
        public static function identify($object) {
            if(is_object($object)) {
                return get_class($object);
            } elseif(is_string($object) && class_exists($object)) {
                return $object;
            } else {
                throw new \InvalidArgumentException;
            }
        }
    }
}