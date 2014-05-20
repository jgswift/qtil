<?php
namespace qtil\Access {
    use qtil;
    
    class Registry extends qtil\Registry {
        /**
         * List of local property names where individual objects store access data
         * @var array 
         */
        protected static $accessProperty = [];
        
        /**
         * Registers access property for object
         * @param mixed $object
         * @param string $propertyName
         */
        public static function setAccessProperty($object,$propertyName) {
            $uid = self::identify($object);
            
            self::$accessProperty[$uid] = $propertyName;
            if(qtil\ReflectorUtil::propertyAccessible($object, $propertyName)) {
                $object->{$propertyName} = [];
            }
        }

        /**
         * Retrieves access property for object
         * defaults to "data"
         * @param mixed $object
         * @return string
         */
        public static function getAccessProperty($object) {
            $uid = self::identify($object);
            
            if(!array_key_exists($uid, self::$accessProperty)) {
                self::$accessProperty[$uid] = 'data';
                if(qtil\ReflectorUtil::propertyAccessible($object, 'data') &&
                   !isset($object->data)) {
                    $object->data = [];
                }
            }
            
            return self::$accessProperty[$uid];
        }
    }
}