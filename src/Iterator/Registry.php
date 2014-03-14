<?php
namespace qtil\Iterator {
    use qtil;
    
    class Registry extends qtil\Access\Registry {
        /**
         * Position of iterators
         * @var array
         */
        private static $positions = [];
        
        /**
         * Retrieve iterator position
         * @param object $iterator
         * @return integer
         */
        public static function getIteratorPosition(\Iterator $iterator) {
            $uid = self::identify($iterator);
            
            if(array_key_exists($uid, self::$positions)) {
                return self::$positions[$uid];
            }
            
            return self::$positions[$uid] = 0;
        }
        
        /**
         * Sets position of iterator
         * @param object $iterator
         * @param integer $position
         */
        public static function setIteratorPosition(\Iterator $iterator,$position) {
            $uid = self::identify($iterator);
            
            self::$positions[$uid] = $position;
        }
        
        /**
         * increments an iterator position
         * @param \Iterator $iterator
         */
        public static function incrementIteratorPosition(\Iterator $iterator) {
            $uid = self::identify($iterator);
            
            if(array_key_exists($uid, self::$positions)) {
                ++self::$positions[$uid];
            }
        }
        
        /**
         * checks if iterator position exists
         * @param \Iterator $iterator
         * @return boolean
         */
        public static function hasIteratorPosition(\Iterator $iterator) {
            $uid = self::identify($iterator);
            
            return array_key_exists($uid, self::$positions);
        }
    }
}