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
        protected function link($name, array $arguments) {
            $qualifiedName = Chain\Registry::getQualifiedName($this,$name);

            $link = self::build($qualifiedName,$arguments);

            if(isset($link)) {
                $linkProperty = Chain\Registry::getLinkProperty($this);
                $this->{$linkProperty}[] = $link;

                return $link;
            } else {
                return null;
            }
        }

        /**
         * Checks if link with given name already exists in chain
         * @param string $name
         * @return boolean
         */
        function hasLink($name) {
            $qualifiedName = Chain\Registry::getQualifiedName($this,$name);
            
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
        function getLink($names) {
            if(!ArrayUtil::isIterable($names)) {
                $names = [$names];
            }
            
            $linkProperty = Chain\Registry::getLinkProperty($this);
            $links = $this->{$linkProperty};
                
            $returnLinks = [];
            foreach($names as $name) {
                $qualifiedName = Chain\Registry::getQualifiedName($this,$name);
                foreach($links as $link) {
                    if($link instanceof $qualifiedName) {
                        $returnLinks[] = $link;
                    }
                }
            }

            return $returnLinks;
        }

        /**
         * Retrieves all links in chain
         * @return array
         */
        function getLinks() {
            $linkProperty = Chain\Registry::getLinkProperty($this);
            return $this->{$linkProperty};
        }

        /**
         * Call magic for chain link creation
         * @param string $name
         * @param array $arguments
         * @return ArrayObject
         */
        function __call($name, array $arguments) {
            $this->link($name, $arguments);

            return $this;
        }
    }
}

