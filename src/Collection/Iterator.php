<?php
namespace qtil\Collection {
    use qtil;
    
    class Iterator implements \ArrayAccess,\Countable,\Iterator {
        use qtil\ArrayAccess,qtil\Countable,qtil\Iterator;
        
        function __construct(array $data = []) {
            $property = defined('static::$DOMAIN_PROPERTY') ? static::$DOMAIN_PROPERTY : 'data';
            
            $this->{$property} = $data;
        }
    }
}
