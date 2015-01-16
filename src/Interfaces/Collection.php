<?php
namespace qtil\Interfaces {
    /**
     * @codeCoverageIgnore
     */
    interface Collection extends \ArrayAccess, \Countable, \IteratorAggregate {
        
        /**
         * Helper method to populate local data
         * @param mixed $param,...
         * @return Collection
         */
        public function from();
        
        /**
         * Populates from array data
         */
        public function fromArray(array $array);
        
        /**
         * creates a new duplicate collection
         * @return Collection
         */
        public function toCollection();
        
        /**
         * Populates from collection data
         * @param Collection $collection
         * @return Collection
         */
        public function fromCollection(Collection $collection);
        
        /**
         * Retrieve the first array item
         * @return mixed
         */
        public function first();
        
        /**
         * Retrieve the last array item
         * @return mixed
         */
        public function last();
        
        /**
         * Checks if item is inside array
         * @return boolean
         */
        public function contains($item);
        
        /**
         * Compares arrays
         * @param mixed $collection
         * @return boolean
         */
        public function equals($collection);
        
        /**
         * Alias to insert
         * @param mixed $value
         * @param mixed $key
         * @return mixed
         */
        public function add($value, $key = null);
        
        /**
         * Inserts item into array
         * @param mixed $key
         * @param mixed $value
         * @return mixed
         */
        public function insert($key = null, $value = null);
        
        /**
         * Removes item from array at specified offset
         * @param mixed $key
         * @return Traversable
         */
        public function remove($key);
        
        /**
         * Checks if offsets exists in array
         * @param mixed $key
         * @return boolean
         */
        public function exists($key);
        
        /**
         * Merges array into local array
         * @param array $data
         * @return Traversable
         * @throws \InvalidArgumentException
         */
        public function merge($data);
        
        /**
         * Removes all items from array
         * @return Traversable
         */
        public function clear();
        
        /**
         * Extract a slice of the array
         * @param integer $amount
         * @return Collection
         */
        public function slice($start, $amount = null, $preserve_keys = false);
        
        /**
         * Remove a portion of the array and replace it with something else
         * @param integer $amount
         * @return Collection|null
         */
        public function splice($start, $amount = null, $replacement = []);
        
        /**
         * Applies function to every value of array
         * @param callable $callable
         * @return void
         */
        function apply(callable $callable);
    }
}