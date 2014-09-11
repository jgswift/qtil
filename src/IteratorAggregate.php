<?php
namespace qtil {
    trait IteratorAggregate {
        /**
         * standard \IteratorAggregate getIterator method
         * @return \Iterator
         */
        public function getIterator() {
            return Iterator\AggregateRegistry::getIteratorAggregate($this);
        }
        
        /**
         * Standard \IteratorAggregate setIterator method
         * @param \Iterator $iterator
         */
        public function setIterator(\Iterator $iterator) {
            Iterator\AggregateRegistry::setIteratorAggregate($this,$iterator);
        }
    }
}