<?php
namespace qtil {
    trait Chain {
        use Factory;
        
        /**
         * Creates link object with built-in factory
         * @param string $name
         * @param array $arguments
         * @return mixed
         */
        public function link($name, array $arguments) {
            $suffix = defined('static::LINK_SUFFIX')
                    ? static::LINK_SUFFIX
                    : '';
            
            $qualifiedName = Chain\Registry::getQualifiedName($this,$name,$suffix);
            
            if(empty($qualifiedName)) {
                throw new \BadMethodCallException(get_class($this).'->'.$name);
            }

            $link = $this->make($qualifiedName,$arguments);

            if(isset($link)) {
                $linkProperty = Chain\Registry::getLinkProperty($this);
                $this->{$linkProperty}[] = $link;

                return $link;
            } else {
                return null;
            }
        }
        
        /**
         * Check if chain link is possible given name
         * @param string $name
         * @return boolean
         */
        public function canLink($name) {
            $suffix = defined('static::LINK_SUFFIX')
                    ? static::LINK_SUFFIX
                    : '';
            
            $qualifiedName = Chain\Registry::getQualifiedName($this,$name,$suffix);
            
            if(class_exists($qualifiedName)) {
                return true;
            }
            
            return false;
        }

        /**
         * Checks if link with given name already exists in chain
         * @param string $name
         * @return boolean
         */
        public function hasLink($name) {
            $suffix = defined('static::LINK_SUFFIX')
                    ? static::LINK_SUFFIX
                    : '';
            
            $qualifiedName = Chain\Registry::getQualifiedName($this,$name,$suffix);
            
            $linkProperty = Chain\Registry::getLinkProperty($this);
            $links = $this->{$linkProperty};
            foreach($links as $link) {
                $linkClass = get_class($link);
                if($linkClass === $qualifiedName) {
                    return true;
                }
            }
            
            return false;
        }

        /**
         * Retrieves all links with given name
         * An array of names may be provided
         * @param type $names
         * @return type
         */
        public function getLink($names) {
            if(!ArrayUtil::isIterable($names)) {
                $names = [$names];
            }
            
            $linkProperty = Chain\Registry::getLinkProperty($this);
            $links = $this->{$linkProperty};
                
            $returnLinks = [];
            foreach($names as $name) {
                $suffix = defined('static::LINK_SUFFIX')
                    ? static::LINK_SUFFIX
                    : '';
            
                $qualifiedName = Chain\Registry::getQualifiedName($this,$name,$suffix);
                foreach($links as $link) {
                    if($link instanceof $qualifiedName) {
                        $returnLinks[] = $link;
                    }
                }
            }

            return $returnLinks;
        }
        
        /**
         * Helper method to add registry namespace definition
         * @param string $namespace
         */
        public function registerNamespace($namespace) {
            Chain\Registry::addNamespace($this, $namespace);
            return $this;
        }
        
        /**
         * Helper method to remove registry namespace definition
         * @param string $namespace
         */
        public function unregisterNamespace($namespace) {
            Chain\Registry::removeNamespace($this, $namespace);
            return $this;
        }

        /**
         * Retrieves all links in chain
         * @return array
         */
        public function getLinks() {
            $linkProperty = Chain\Registry::getLinkProperty($this);
            return $this->{$linkProperty};
        }

        /**
         * Call magic for chain link creation
         * @param string $name
         * @param array $arguments
         * @return self
         */
        public function __call($name, array $arguments) {
            $this->link($name, $arguments);

            return $this;
        }
    }
}

