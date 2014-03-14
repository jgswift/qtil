<?php
namespace qtil\Chain {
    use qtil;
    
    class Registry extends qtil\Registry {
        /**
         * List of properties that chain objects use to store links locally
         * @var array
         */
        protected static $linkProperty = [];
        
        /**
         * List of namespaces that chain objects access when creating new links
         * @var array
         */
        protected static $chainNamespace = [];
        
        /**
         * Retrieves full class path from chain link name
         * @param object $object
         * @param string $name
         * @return string
         */
        public static function getQualifiedName($object,$name) {
            $chainNamespace = self::getChainNamespace($object);
            if(!empty($chainNamespace)) {
                $qualifiedName = $chainNamespace.'\\'.$name;
            } else {
                $qualifiedName = get_class($object).'\\'.$name;
            }
            
            return $qualifiedName;
        }
        
        /**
         * Retrieves property where links are locally stores on chain object
         * @param object $object
         * @return string
         */
        public static function getLinkProperty($object) {
            $uid = self::identify($object);
            
            if(!array_key_exists($uid, self::$linkProperty)) {
                self::$linkProperty[$uid] = 'links';
                if(!isset($object->links)) {
                    $object->links = [];
                }
            }
            
            return self::$linkProperty[$uid];
        }
        
        /**
         * Registers link property where chain object locally stores links
         * @param object $object
         * @param string $property
         * @return type
         */
        public static function setLinkProperty($object,$property) {
            $uid = self::identify($object);
            
            self::$linkProperty[$uid] = $property;
            
            return $property;
        }
        
        /**
         * Retrieves namespace where link classes exist
         * @param object $object
         * @return string
         */
        public static function getChainNamespace($object) {
            $uid = self::identify($object);
            
            if(!array_key_exists($uid, self::$chainNamespace)) {
                self::$chainNamespace[$uid] = get_class($object);
            }
            
            return self::$chainNamespace[$uid];
        }
        
        /**
         * Registers namespace where link classes exist
         * @param object $object
         * @param string $namespace
         * @return string
         */
        public static function setChainNamespace($object,$namespace) {
            $uid = self::identify($object);
            
            self::$chainNamespace[$uid] = $namespace;
            
            return $namespace;
        }
    }
}