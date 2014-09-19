<?php
namespace qtil {
    trait Generator {       
        /**
         * Retrieves generator
         * @return type
         */
        public function getGenerator() {
            return Iterator\AggregateRegistry::getGenerator($this);
        }
        
        /**
         * Updates generator with callable that implements "yield"
         * @param callable $generator
         */
        public function setGenerator(callable $generator) {
            Iterator\AggregateRegistry::setGenerator($this, $generator);
        }
    }
}