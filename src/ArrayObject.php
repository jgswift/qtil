<?php
namespace qtil {
    trait ArrayObject {
        /*
         * @method void offsetSet($name,$value)
         * @method void offsetUnset($name)
         * @method boolean offsetExists($name)
         */
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
         * @return ArrayObject
         */
        public function remove($key) {
            $this->offsetUnset($key);

            return $this;
        }

        /**
         * Checks if offsets exists in array
         * @param mixed $offset
         * @return boolean
         */
        public function exists($key) {
            return $this->offsetExists($key);
        }

        /**
         * Merges array into local array
         * @param array $data
         * @return ArrayObject
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
         * @return ArrayObject
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
    }
}