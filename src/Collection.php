<?php
namespace qtil {
    class Collection implements Interfaces\Collection {
        use ArrayAccess,Traversable,Countable,IteratorAggregate,Generator;
                
        function __construct() {
            if(func_num_args()) {
                call_user_func_array([$this,'from'],  func_get_args());
            }
        }
    }
}
