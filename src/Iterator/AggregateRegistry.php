<?php
namespace qtil\Iterator {
    use qtil;
    
    class AggregateRegistry extends qtil\Access\Registry {
        /**
         * List of aggregators
         * @var array
         */
        private static $iteratorAggregates = [];
        
        private static $generatorAggregates = [];
        
        /**
         * Retrieve aggregator for object
         * @param mixed $object
         * @return \Iterator
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
         * @param mixed $object
         * @param \Iterator $iterator
         */
        public static function setIteratorAggregate($object,\Iterator $iterator) {
            $uid = self::identify($object);
            
            self::$iteratorAggregates[$uid] = $iterator;
        }
        
        public static function getGenerator($object) {
            $uid = self::identify($object);
            
            if(array_key_exists($uid,self::$generatorAggregates)) {
                $generator = self::$generatorAggregates[$uid];
            } else {
                $generator = self::getDefaultGenerator();
            }
            
            return $generator($object);
        }
        
        public static function setGenerator($object, callable $generator) {
            $uid = self::identify($object);
            
            self::$generatorAggregates[$uid] = $generator;
        }
        
        protected static function getDefaultGenerator() {
            return function($items) {
                foreach($items as $item) {
                    yield $item;
                }
            };
        }
    }
}