<?php
namespace qtil\Tests\Mock {
    use qtil;
    
    class FooIteratorAggregate implements \IteratorAggregate {
        use qtil\IteratorAggregate;
        
        public $data = ['foo' => 'bar'];
    }
}
