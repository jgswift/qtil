<?php
namespace qtil\Collection {
    use qtil;
    
    class Iterator implements \ArrayAccess,\Countable,\Iterator {
        use qtil\ArrayAccess,qtil\ArrayObject,qtil\Countable,qtil\Iterator;
        
        function __construct(array $data = []) {
            $property = qtil\Access\Registry::getAccessProperty($this);
            
            $this->{$property} = $data;
        }
    }
}
