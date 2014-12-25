<?php
namespace qtil\Chain {
    use qtil;
    use qtil\Identifier;
    
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
         * @param mixed $object
         * @param string $name
         * @return string
         */        
        public static function getQualifiedName($object,$name, $suffix=null) {
            $chainNamespaces = self::getNamespaces($object);
            
            foreach($chainNamespaces as $chainNamespace) {
                $qualifiedNames = [];
                
                if(is_null($suffix)) {
                    $suffix = '';
                }
                
                $qualifiedNames[] = $chainNamespace.'\\'.$name.$suffix;
                $qualifiedNames[] = $chainNamespace.'\\'.ucfirst($name).$suffix;
                
                foreach($qualifiedNames as $qname) {
                    if(class_exists($qname)) {
                        return $qname;
                    }
                }
            }
        }
        
        /**
         * Retrieves property where links are locally stores on chain object
         * @param mixed $object
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
         * @param mixed $object
         * @param string $property
         * @return string
         */
        public static function setLinkProperty($object,$property) {
            $uid = self::identify($object);
            
            self::$linkProperty[$uid] = $property;
            
            return $property;
        }
        
        /**
         * Retrieves namespace where link classes exist
         * @param mixed $object
         * @return array
         */
        public static function getNamespaces($object) {
            $uid = self::identify($object);
            if(!array_key_exists($uid, self::$chainNamespace)) {
                self::$chainNamespace[$uid] = array_merge([get_class($object)],class_parents($object));
            }

            return self::$chainNamespace[$uid];
        }
        
        /**
         * Registers namespace where link classes exist
         * @param  $object
         * @param string $namespace
         * @return string
         */
        public static function addNamespace($object,$namespace) {
            $uid = self::identify($object);
            
            if(!array_key_exists($uid, self::$chainNamespace)) {
                self::$chainNamespace[$uid] = array_merge([get_class($object)],class_parents($object));
            }
            
            if(!in_array($namespace, self::$chainNamespace[$uid])) {
                self::$chainNamespace[$uid][] = $namespace;
            }
            
            return $namespace;
        }
        
        /**
         * Removes namespace from registry
         * @param  $object
         * @param string $namespace
         */
        public static function removeNamespace($object,$namespace) {
            $uid = self::identify($object);
            
            if(array_key_exists($uid, self::$chainNamespace)) {
                $key = array_search($namespace,self::$chainNamespace[$uid]);
                if($key) {
                    unset(self::$chainNamespace[$uid][$key]);
                }
            }
        }
    }
}