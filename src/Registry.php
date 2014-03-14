<?php
namespace qtil {
    use kindentfy;
    
    abstract class Registry {
        /**
         * Array of objects keyed by unique id
         * @var array
         */
        protected static $uids = [];
        
        /**
         * Retrieve a unique identifier for object instance
         * @param mixed $object
         * @return string
         */
        protected static function identify($object) {
            if(($uid = array_search($object,self::$uids))) {
                return $uid;
            }

            $uid = kindentfy\Identifier::identify($object);
            self::$uids[$uid] = $object;
            return $uid;
        }
        
        /**
         * Checks if object is already present in local memory
         * @param mixed $object
         * @return boolean
         * @throws \InvalidArgumentException
         */
        protected static function manages($object) {
            if(is_string($object)) {
                $uid = $object;
                return array_key_exists($uid,self::$uids);
            } elseif(is_object($object)) {
                if(($uid = array_search($object,self::$uids))) {
                    return true;
                }
                return false;
            }
            
            throw new \InvalidArgumentException();
        }
    }
}