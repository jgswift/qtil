<?php
namespace qtil {
    trait Executable {
        
        /**
         * Simply routes invoke to sibling method "execute"
         * @return mixed
         */
        function __invoke() {
            return call_user_func_array([$this, 'execute'], func_get_args());
        }
    }
}