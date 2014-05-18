<?php
namespace qtil\Tests\Mock {
    use qtil;
    
    class FooCollection extends qtil\Collection {
        use qtil\JSONAccess;
        
        public $data = [];
    }
}
