<?php
namespace qtil {
    class Identifier {
        private static $schemes = [];
        private static $hashes = [];
        
        /**
         * Retrieves list of current identification schemes
         * @return array
         */
        static function getSchemes() {
            return self::$schemes;
        }
        
        /**
         * Sets and overwrites list of current identification schemes
         * @param array $schemes
         * @return array
         */
        static function setSchemes(array $schemes) {
            foreach($schemes as $scheme) {
                self::addScheme($scheme);
            }
            
            return $schemes;
        }
        
        /**
         * Adds a scheme to current identification schemes
         * @param \qtil\Identifier\Scheme $scheme
         * @return \qtil\Identifier\Scheme
         */
        static function addScheme(Identifier\Scheme $scheme) {
            return self::$schemes[] = $scheme;
        }
        
        /**
         * Removes a scheme from current identification schemes
         * @param \qtil\Identifier\Scheme $scheme
         */
        static function removeScheme(Identifier\Scheme $scheme) {
            foreach(self::$schemes as $k => $s) {
                if($s === $scheme) {
                    unset(self::$schemes[$k]);
                    break;
                }
            }
        }
        
        /**
         * Clears all identification schemes
         */
        static function clearSchemes() {
            self::$schemes = [];
        }
        
        /**
         * Performs object identification
         * @param mixed $object
         * @return string
         */
        static function identify($object) {
            $id = null;
            if(!empty(self::$schemes)) {
                foreach(self::$schemes as $scheme) {
                    if($scheme->applies($object)) {
                        $id = $scheme->getIdentity($object);
                        break;
                    }
                }
            }
            
            if(is_null($id)) {
                if($object instanceof \qtil\Interfaces\ID) {
                    $id = $object->id();
                } elseif($object instanceof \qtil\Interfaces\UID) {
                    $id = $object->uid();
                } else {
                    $id = self::createUniqueIdentifier($object);
                }
            }
            
            return $id;
        }
        
        /**
         * helper method to ensure object uniqueness
         * @param mixed $object
         * @return string
         */
        private static function createUniqueIdentifier($object) {
            if(($k=array_search($object,self::$hashes,true)) !== false) {
                return $k;
            }

            $hash = md5(uniqid());
            while (array_key_exists($hash, self::$hashes)) {
                $hash = md5(uniqid());
            }
            
            self::$hashes[$hash] = $object;
            return $hash;
        }
    }
}
