<?php
namespace qtil\Reflector {
    class Registry {
        /**
         * list of \ReflectionClass objects
         * @var array 
         */
        protected static $reflectors = [];
        
        /**
         * 
         * @param mixed $class
         * @return \ReflectionClass
         */
        public static function getReflector($class) {
            if(is_object($class)) {
                $class = get_class($class);
            }
            
            if(self::isReflected($class)) {
                return self::$reflectors[$class];
            } 
            
            return self::createReflector($class);
        }
        
        /**
         * Creates \ReflectionClass from provided className
         * Returns null if class does not exist
         * @param string $class
         * @return mixed
         */
        private static function createReflector($class,$autoload=true) {
            if(class_exists($class,$autoload)) {
                return self::$reflectors[$class] = new \ReflectionClass($class);
            }
        }
        
        /**
         * Checks if local storage contains \ReflectionClass for a class
         * @param mixed $class
         * @return boolean
         */
        private static function isReflected($class) {
            if(is_object($class)) {
                $class = get_class($class);
            }
            
            return array_key_exists($class, self::$reflectors);
        }
    }
}