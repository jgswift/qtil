<?php
namespace qtil {
    class ArrayUtil {
        /**
         * Helper function to check if array is multidimensional
         * @param mixed $array
         * @return boolean
         */
        static function isMultidimensional($array) {
            if(!self::isIterable($array)) {
                return false;
            }

            foreach($array as $v) {
                if (is_array($v)) {
                    return true;
                }
            }
                
            return false;
        }
        
        /**
         * Counts iterable objects as arrays
         * @param mixed $array
         */
        static function isMultiObject($array) {
            if(!self::isMultidimensional($array) && self::isIterable($array)) {
                foreach($array as $v) {
                    if (self::isIterable($v)) {
                        return true;
                    }
                }
            }
            
            return false;
        }
        
        /**
         * Alias for isMultidimensional
         * @param mixed $array
         * @return boolean
         */
        static function isMulti($array) {
            return self::isMultidimensional($array);
        }
        
        /**
         * Checks if argument is array literal or implementing Traversable interface
         * @param mixed $array
         * @return boolean
         */
        static function isIterable($array) {
            return \is_array($array) ||
                    ($array instanceof \ArrayAccess  &&
                     $array instanceof \Traversable);
        }
        
        /**
         * Helper function to perform difference association 
         * Will maintain associative key index
         * @param array $aArray1
         * @param array $aArray2
         * @param boolean $recursion
         * @return array
         */
        static function diffAssoc(array $aArray1, array $aArray2, $recursion = true) {
            $aReturn = [];

            foreach ($aArray1 as $mKey => $mValue) {
                if (\array_key_exists($mKey, $aArray2)) {
                    if (\is_array($mValue) && $recursion) {
                        $aRecursiveDiff = self::diffAssoc($mValue, $aArray2[$mKey]);
                        if (count($aRecursiveDiff)) { $aReturn[$mKey] = $aRecursiveDiff; }
                    } else {
                        if ($mValue != $aArray2[$mKey]) {
                            $aReturn[$mKey] = $mValue;
                        }
                    }
                } else {
                    $aReturn[$mKey] = $mValue;
                }
            }

            return $aReturn;
        }
        
        /**
         * Inserts an array into another array at a specified index
         * @param array $array
         * @param array $pairs
         * @param mixed $key
         * @param string $position "before" or "after"
         * @return array
         */
        static function insertArray($array, $pairs, $key, $position = 'after') {
            if(!self::isIterable($array)) {
                throw new \InvalidArgumentException();
            }
            
            $array = (array)$array;
            
            $key_pos = \array_search($key, \array_keys($array));

            if ('after' === $position) {
                $key_pos++;
            }

            if(false !== $key_pos) {
                $slice = \array_slice($array, 0, $key_pos);
                $merge = \array_merge($slice, $pairs);
                $result = \array_merge($merge, \array_slice($array, $key_pos));
            } else {
                $result = \array_merge($array, $pairs);
            }

            return $result;
        }
        
        /**
         * Compute whether or not needle array exists in haystack
         * and return all matching keys
         * @param array $needle
         * @param array $haystack
         * @return array
         */
        protected function containsArray(array $needle, array $haystack) {
            $keys = array_keys($haystack, $needle[0]);
            $out = [];
            foreach($keys as $key) {
                $add = true;
                $result = [];
                foreach($needle as $i => $value) {
                    if(!(isset($haystack[$key + $i]) && $haystack[$key + $i] == $value)) {
                        $add = false;
                        break;
                    }
                    $result[] = $key + $i;
                }
                if($add == true) { 
                    $out[] = $result;
                }
            }
            return $out;
        }
        
        /**
         * Shortcut method to built-in php array_* functions
         * @param string $functionName
         * @param mixed $argv
         * @return mixed
         * @throws \BadMethodCallException
         */
        public static function __callStatic($functionName, $argv) {
            if(!substr($functionName, 0, 6) !== 'array_') {
                $functionName = 'array_'.$functionName;
            }

            if (!is_callable($functionName) || 
                substr($functionName, 0, 6) !== 'array_') {
                throw new \BadMethodCallException(__CLASS__.'::'.$functionName);
            }

            return call_user_func_array($functionName, $argv);
        }
    }
}