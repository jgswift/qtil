<?php
namespace qtil {
    class ReflectorUtil {
        /**
         * parses absolute class path
         * @param type $name
         * @return type an array with the namespace and classname extracted
         */
        public static function extractClassInfo($name) {
            if(\is_object($name)) {
                $name = \get_class($name);
            }

            return [
                'namespace' => \array_slice(\explode('\\', $name), 0, -1),
                'classname' => \implode('', \array_slice(\explode('\\', $name), -1)),
            ];
        }
        
        /**
         * Retrieves class name without namespace
         * @param mixed $class
         * @return false|string
         */
        public static function getClassName($class) {
            if (!is_object($class) && !is_string($class)) {
                return false;
            }

            return trim(strrchr((is_string($class) ? $class : get_class($class)), '\\'), '\\');
        }
        
        /**
         * check if class is currently implementing trait
         * may also recursively check all parent classes for trait
         * @param string $class
         * @param string $trait
         * @param boolean $recursive
         * @return boolean
         */
        public static function usesTrait($class, $trait,$recursive=false) {
            if(($traits = self::classUses($class,$trait,$recursive)) !== false) {
                if($traits === true) {
                    return true;
                } elseif(is_array($traits)) {
                    return \in_array($trait, $traits);
                }
            }

            return false;
        }
        
        /**
         * 
         * @param type $class
         * @param type $trait
         * @param type $recursive
         * @return boolean
         */
        public static function classUses($class,$trait,$recursive=true) {
            if(!\is_object($class) && !\is_string($class)) {
                return false;
            }

            $traits = \class_uses($class);

            if($recursive) {
                $parent = \get_parent_class($class);

                while($parent !== false) {
                    $traits = \array_merge($traits,\class_uses($parent));
                    $parent = \get_parent_class($parent);
                }
            }

            if(!is_array($trait)) {
                $trait = (array)$trait;
            }

            foreach($traits as $k => $t) {
                if(\in_array($t,$trait)) {
                    return true;
                }

                if(self::classUses($t,$trait)) {
                    return true;
                }

                unset($traits[$k]);
            }

            return false;
        }
        
        /**
         * Check if property is publicly accessible
         * @param object|string $class
         * @param string $property
         * @return boolean
         */
        public static function propertyAccessible($class,$property) {
            if(\is_object($class)) {
                $class = get_class($class);
            }
            
            if(!\class_exists($class)) {
                return false;
            }
            
            return in_array($property,array_keys(get_class_vars($class)));
        }
    }
}
