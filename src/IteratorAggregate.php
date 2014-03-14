<?php
namespace qtil {
    trait IteratorAggregate {
        /**
         * standard \IteratorAggregate getIterator method
         * @return \Iterator
         */
        function getIterator() {
            return Iterator\AggregateRegistry::getIteratorAggregate($this);
        }
    }
}