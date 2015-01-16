<?php
namespace qtil {
    trait Generator {
        /**
         * Locally store generator callable
         * @var callable 
         */
        protected $generatorCallable;
        
        /**
         * Retrieves generator
         * @return callable
         */
        public function getGenerator() {
            if(empty($this->generatorCallable)) {
                $this->generatorCallable = function($v) {
                    return $v;
                };
            }
            
            $generator = function() {
                foreach($this->{static::$DOMAIN_PROPERTY} as $item) {
                    yield call_user_func_array($this->generatorCallable, [$item]);
                }
            };
            
            return $generator();
        }
        
        /**
         * Updates generator with callable that is wrapped by "yield"
         * @param callable $generator
         */
        public function setGenerator(callable $generator) {
            return $this->generatorCallable = $generator;
        }
    }
}