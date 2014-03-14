<?php
namespace qtil\Tests\Mock {
    use qtil;
    
    class FooArrayAccess extends qtil\Collection {
        use qtil\JSONAccess;
        
        public $data = [];
    }
}
