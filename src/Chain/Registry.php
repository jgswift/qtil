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
         * @param mixed $object
         * @param string $name
         * @return string
         */        
        public static function getQualifiedName($object,$name, $suffix=null) {
            $chainNamespaces = array_merge(self::getNamespaces($object),ClassRegistry::getNamespaces($object));
            
            //var_dump(ClassRegistry::getNamespaces($object));
            
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
            $uid = static::identify($object);
            
            if(!array_key_exists($uid, static::$linkProperty)) {
                static::$linkProperty[$uid] = 'links';
                if(!isset($object->links)) {
                    $object->links = [];
                }
            }
            
            return static::$linkProperty[$uid];
        }
        
        /**
         * Registers link property where chain object locally stores links
         * @param mixed $object
         * @param string $property
         * @return string
         */
        public static function setLinkProperty($object,$property) {
            $uid = static::identify($object);
            
            static::$linkProperty[$uid] = $property;
            
            return $property;
        }
        
        /**
         * Helper method to retrieve relevant chain classes
         * @param mixed $object
         * @return array
         * @throws \InvalidArgumentException
         */
        private static function getChainData($object) {
            $uid = static::identify($object);
            if(is_object($object)) {
                $class = get_class($object);
            } elseif(is_string($object) && class_exists($object)) {
                $class = $object;
            } else {
                throw new \InvalidArgumentException;
            }
            
            $parents = class_parents($class);
            
            return [$uid, $class, $parents];
        }
        
        /**
         * Retrieves namespace where link classes exist
         * @param mixed $object
         * @return array
         */
        public static function getNamespaces($object) {
            list($uid, $class, $parents) = self::getChainData($object);
            
            if(!array_key_exists($uid, static::$chainNamespace)) {
                static::$chainNamespace[$uid] = array_merge([$class],$parents);
            }

            return static::$chainNamespace[$uid];
        }
        
        /**
         * Registers namespace where link classes exist
         * @param  $object
         * @param string $namespace
         * @return string
         */
        public static function addNamespace($object,$namespace) {
            list($uid, $class, $parents) = self::getChainData($object);
            
            if(!array_key_exists($uid, static::$chainNamespace)) {
                static::$chainNamespace[$uid] = array_merge([$class],$parents);
            }
            
            if(!in_array($namespace, static::$chainNamespace[$uid])) {
                static::$chainNamespace[$uid][] = $namespace;
            }
            
            return $namespace;
        }
        
        /**
         * Removes namespace from registry
         * @param  $object
         * @param string $namespace
         */
        public static function removeNamespace($object,$namespace) {
            $uid = static::identify($object);
            
            if(array_key_exists($uid, static::$chainNamespace)) {
                $key = array_search($namespace,static::$chainNamespace[$uid]);
                if($key) {
                    unset(static::$chainNamespace[$uid][$key]);
                }
            }
        }
    }
}