<?php
namespace qtil\Tests\Mock {
    use qtil;
    
    class FooObjectAccess implements \Serializable {
        use qtil\ObjectAccess,qtil\Serializable;
        
        protected $data = [];
    }
}