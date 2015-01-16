<?php
namespace qtil\Tests\Mock {
    use qtil;
    
    class FooIteratorAggregate implements \IteratorAggregate {
        use qtil\IteratorAggregate;
        
        protected $data = ['foo' => 'bar'];
    }
}
