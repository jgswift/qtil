<?php
namespace qtil {
    class StringUtil {
        
        /**
         * Checks if string is encoded with JSON data
         * @param string $string
         * @return boolean
         */
        public static function isJSON($string) {
            try {
                JSONUtil::decode($string);
            } catch(Exception $e) {
                return false;
            }
            
            return true;
        }
        
        /**
         * Checks if string ends with certain string
         * @param string $string
         * @param string $char
         * @return boolean
         */
        public static function endsWith($string, $char) {
            $length = strlen($char);
            $start =  $length *-1; //negative
            return (substr($string, $start, $length) === $char);
        }
        
        /**
         * Checks if string starts with certain string
         * @param string $string
         * @param string $char
         * @return boolean
         */
        public static function startsWith($string, $char) {
            $length = strlen($char);
            return (substr($string, 0, $length) === $char);
        }
        
        /**
         * Converts string using : and ; delimeters to array
         * @param string $string
         * @return array
         */
        public static function explodeArray($string) {
            $rule_strings = explode(';', $string);

            $rules = [];
            foreach($rule_strings as $rule_s) {
                $items = explode(':', $rule_s);
                if(count($items) == 2) {
                    list($name, $value) = $items;
                    $rules[$name] = $value;
                }
            }

            return $rules;
        }
        
        /**
         * Converts array into string representation using : and ; as delimeters
         * @param array $array
         * @return string
         */
        public static function implodeArray($array) {
            if(!ArrayUtil::isIterable($array)) {
                return '';
            }

            $array = (array)$array;
            $css_s = '';
            foreach($array as $rule => $value)
            {
                $css_s .= (string)$rule.':'.(string)$value.';';
            }

            return $css_s;
        }

        /**
         * Searches array of strings for needles
         * @param array $haystack
         * @param array $needles
         * @param int $offset
         * @return array
         */
        public static function strposInArray($haystack, $needles, $offset=0) {
            $matches = array();

            //Avoid the obvious: when haystack or needles are empty, return no matches
            if(empty($needles) || empty($haystack)) {
                return $matches;
            }

            $haystack = (string)$haystack; //Pre-cast non-string haystacks
            $haylen = strlen($haystack);

            //Allow negative (from end of haystack) offsets
            if($offset < 0) {
                $offset += $haylen;
            }

            //Use strpos if there is no array or only one needle
            if(!is_array($needles)) {
                $needles = [$needles];
            }

            $needles = array_unique($needles); //Not necessary if you are sure all needles are unique

            //Precalculate needle lengths to save time
            foreach($needles as &$origNeedle) {
                $origNeedle = [(string)$origNeedle, strlen($origNeedle)];
            }

            //Find matches
            for(; $offset < $haylen; $offset++) {
                foreach($needles as $needle) {
                    list($needle, $length) = $needle;
                    if($needle == substr($haystack, $offset, $length)) {
                        $matches[] = $offset;
                        break;
                    }
                }
            }

            return($matches);
        }
        
        /**
        * Check if a string is serialized
        * @param string $string
        */
        function isSerial($string) {
            return (unserialize($string) !== false);
        }
    }
}