<?php
namespace qtil {
    class Collection implements \ArrayAccess,\Countable,\IteratorAggregate {
        use ArrayAccess,ArrayObject,Countable,IteratorAggregate;
        
        function __construct(array $data = []) {
            $property = Access\Registry::getAccessProperty($this);
            
            $this->{$property} = $data;
        }
    }
}
