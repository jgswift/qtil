<?php
namespace qtil {
    trait Reflector {
        /**
         * @param string [ $className ]
         * @return \ReflectionClass
         */
        static function reflect($class = null) {
            if(is_null($class)) {
                $class = get_called_class();
            }
            
            return Reflector\Registry::getReflector($class);
        }
    }
}


