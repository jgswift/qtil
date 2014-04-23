<?php
namespace qtil {
    trait Traversable {
        /*
         * @method void offsetSet($name,$value)
         * @method void offsetUnset($name)
         * @method boolean offsetExists($name)
         * @method mixed offsetGet()
         */
        
        /**
         * Applies function to every value of array
         * @param callable $callable
         */
        function apply(callable $callable) {
            $array = $this->toArray();
            
            array_walk($array,$callable);
            
            $this->fromArray($array);
        }
        
        /**
         * Extract a slice of the array
         * @param integer $start
         * @param integer $amount
         * @param boolean $preserve_keys
         * @return self
         */
        public function slice($start, $amount = null, $preserve_keys = false) {
            $array = $this->toArray();
            
            return new Collection(array_slice($array,$start,$amount,$preserve_keys));
        }
        
        /**
         * Remove a portion of the array and replace it with something else
         * @param integer $start
         * @param integer $amount
         * @param mixed $replacement
         * @return self
         */
        public function splice($start, $amount = null, $replacement = []) {
            $array = $this->toArray();
            
            $this->fromArray(array_splice($array,$start,$amount,$replacement));
        }
        
        /**
         * Checks if value is contained within array
         * @param mixed $item
         */
        public function contains($item) {
            $array = $this->toArray();
            
            foreach($array as $value) {
                if($item === $value) {
                    return true;
                }
            }
            
            return false;
        }

        /**
         * Retrieves first item in array
         */
        public function first() {
            $keys = array_keys($this->toArray());
            if(!empty($keys)) {
                return $this[$keys[0]];
            }
        }

        /**
         * Populates array from another collection
         * @param \qtil\Collection $collection
         */
        public function fromCollection(Interfaces\Collection $collection) {
            $this->fromArray($collection->toArray());
        }

        /**
         * Retrieves last value in array
         * @return mixed
         */
        public function last() {
            $keys = array_keys($this->toArray());
            if(!empty($keys)) {
                return $this[sizeof($keys)-1];
            }
        }

        /**
         * creates a duplicate collection
         * @return Collection
         */
        public function toCollection() {
            return new Collection($this->toArray());
        }
        
        /**
         * Compares arrays
         * @param mixed $collection
         * @return boolean
         */
        public function equals($collection) {
            if(!ArrayUtil::isIterable($collection)) {
                return false;
            }

            if(count($collection) <> count($this)) {
                return false;
            }

            foreach($collection as $k => $item) {
                if(isset($this[$k])) {
                    $v = $this[$k];
                    if($v instanceof Interfaces\Comparable &&
                       !$v->equals($item)) {
                        return false;
                    } elseif(!($v == $item)) {
                        return false;
                    }
                } else {
                    return false;
                }
            }

            return true;
        }

        /**
         * Alias to insert
         * @param mixed $value
         * @param mixed $key
         * @return mixed
         */
        public function add($value, $key = null) {
            $this->insert($key, $value);

            return $value;
        }

        /**
         * Inserts item into array
         * @param mixed $key
         * @param mixed $value
         * @return mixed
         */
        public function insert($key = null, $value = null) {
            if(is_null($value)) {
                $value = $key;
                
                $key = count($this);
            }

            if(is_null($key)) {
                $key = count($this);
            }
            
            $this->offsetSet($key, $value);

            return $value;
        }

        /**
         * Removes item from array at specified offset
         * @param mixed $key
         * @return Traversable
         */
        public function remove($key) {
            $this->offsetUnset($key);

            return $this;
        }

        /**
         * Checks if offsets exists in array
         * @param mixed $key
         * @return boolean
         */
        public function exists($key) {
            return $this->offsetExists($key);
        }

        /**
         * Merges array into local array
         * @param array $data
         * @return Traversable
         * @throws \InvalidArgumentException
         */
        public function merge($data) {
            if(!ArrayUtil::isIterable($data)) {
                throw new \InvalidArgumentException();
            }

            foreach($data as $key => $val) {
                $this->insert($key, $val);
            }

            return $this;
        }

        /**
         * Removes all items from array
         * @return Traversable
         */
        public function clear() {
            $this->fromArray([]);
            
            return $this;
        }
        
        /**
         * Retrieves access property value, creates empty array if none available
         * @return array
         */
        public function toArray() {
            $property = Access\Registry::getAccessProperty($this);
            
            if(!isset($this->{$property})) {
                $this->{$property} = [];
            }

            return (array)$this->{$property};
        }
        
        /**
         * Sets access property value
         * @param array $array
         * @return array input array
         */
        public function fromArray(array $array) {
            $property = Access\Registry::getAccessProperty($this);
            $this->{$property} = $array;
            
            return $array;
        }
        
        /**
         * Variadic helper function to populate object
         * @return array
         */
        public function from() {
            $numArgs = func_num_args();
            $args = func_get_args();
            if($numArgs === 1) {
                if(is_array($args[0])) {
                    return $this->fromArray($args[0]);
                } elseif($args[0] instanceof \Iterator) {
                    $this->fromArray(iterator_to_array($args[0]));
                } elseif($args[0] instanceof Interfaces\Traversable) {
                    $this->fromArray($args[0]->toArray());
                }
            } 
            
            return $this->fromArray($args);
        }
    }
}