<?php
namespace qtil\Interfaces {
    interface Chain {
        /**
         * @return array List of current links
         */
        public function getLinks();
        
        /**
         * create a new chain link
         * @param string $name
         * @param array $arguments
         */
        public function link($name, array $arguments);
        
        /**
         * Check if key is linkable
         * @param string $name
         */
        public function canLink($name);
        
        /**
         * Check if link exists already
         * @param string $name
         */
        public function hasLink($name);
        
        /**
         * Retrieve all links by key
         * @param string $name
         */
        public function getLink($name);
    }
}