<?php
namespace qtil\Iterator {
    use qtil;
    
    class AggregateRegistry extends qtil\Access\Registry {
        /**
         * List of aggregators
         * @var array
         */
        private static $iteratorAggregates = [];
        
        /**
         * Retrieve aggregator for object
         * @param mixed $object
         * @return \IteratorAggregate
         */
        public static function getIteratorAggregate($object) {
            $uid = self::identify($object);
            
            if(array_key_exists($uid, self::$iteratorAggregates)) {
                return self::$iteratorAggregates[$uid];
            } 
            
            $property = qtil\Access\Registry::getAccessProperty($object);

            $data = [];
            if(!empty($property)) {
                $data = (array)$object->{$property};
            }

            return self::$iteratorAggregates[$uid] = new \ArrayIterator($data);
        }
        
        /**
         * set aggregator for object
         * @param object $object
         * @param \Iterator $iterator
         */
        public static function setIteratorAggregate($object,\Iterator $iterator) {
            $uid = self::identify($object);
            
            self::$iteratorAggregates[$uid] = $iterator;
        }
    }
}