<?php
namespace qtil\Interfaces {
    /**
     * @codeCoverageIgnore
     */
    interface Node {
        /**
         * Retrieves immediate node parent
         */
        function getParent();
        
        /**
         * Checks if node is top level
         */
        function isRoot();
        
        /**
         * Retrieve top level node in hierarchy
         */
        function getRoot();
        
        /**
         * Set immediate node parent
         * @param mixed $parent
         */
        function setParent($parent);
    }
}