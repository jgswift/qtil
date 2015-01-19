<?php
namespace qtil {
    use restructr\Interfaces\Enumerable;
    
    trait JSONAccess {
        /**
         * Converts access property data to json string
         * @return string
         */
        function toJSON() {
            if($this instanceof Enumerable) {
                return JSONUtil::encode($this->toArray());
            }
            
            $property = defined('static::$DOMAIN_PROPERTY') ? static::$DOMAIN_PROPERTY : 'data';
            if(!isset($this->{$property})) {
                $this->{$property} = [];
            }

            return JSONUtil::encode($this->{$property});
        }
        
        /**
         * Converts json string to array and sets local access property
         * @param string $input
         * @return array
         */
        public function fromJSON($input) {
            if($this instanceof Interfaces\Collection) {
                $this->fromArray((array)JSONUtil::decode($input));
                return $input;
            }
            
            $property = defined('static::$DOMAIN_PROPERTY') ? static::$DOMAIN_PROPERTY : 'data';
            $this->{$property} = (array)JSONUtil::decode($input);
            return $input;
        }
    }
}