<?php
namespace qtil\Tests\Mock {
    use qtil;
    
    class FooExecutable {
        use qtil\Executable;
        
        function execute() {
            return 'bar';
        }
    }
}