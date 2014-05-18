<?php
namespace qtil\Tests\Mock {
    use qtil;
    
    class FooArrayAccess implements \ArrayAccess, \Countable, \Iterator {
        use qtil\ArrayAccess;
        use qtil\Countable;
        use qtil\Iterator;
    }
}
