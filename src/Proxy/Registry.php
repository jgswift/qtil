<?php
namespace qtil\Proxy {
    use qtil;
    
    class Registry extends qtil\Registry {
        
        /**
         * List of proxy object subjects
         * @var array
         */
        private static $subjects = [];
        
        /**
         * Retrieves registered subject for proxy object
         * @param object $object
         * @return mixed
         */
        public static function getSubject($object) {
            $uid = self::identify($object);
            
            if(array_key_exists($uid,self::$subjects)) {
                return self::$subjects[$uid];
            }
        }
        
        /**
         * Registers subject for proxy object
         * @param object $object
         * @param object $subject
         */
        public static function setSubject($object,$subject) {
            $uid = self::identify($object);
            
            self::$subjects[$uid] = $subject;
            
            return $subject;
        }
    }
}
