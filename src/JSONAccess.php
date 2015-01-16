<?php
namespace qtil {
    trait JSONAccess {
        /*
         * @method array toArray()
         * @method array fromArray(array $array)
         */
        
        /**
         * Converts access property data to json string
         * @return string
         */
        function toJSON() {
            if(method_exists($this,'toArray')) {
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
         * @param type $input
         * @return type
         */
        public function fromJSON($input) {
            if(method_exists($this,'fromArray')) {
                $this->fromArray((array)JSONUtil::decode($input));
                return $input;
            }
            
            $property = defined('static::$DOMAIN_PROPERTY') ? static::$DOMAIN_PROPERTY : 'data';
            $this->{$property} = (array)JSONUtil::decode($input);
            return $input;
        }
    }
}