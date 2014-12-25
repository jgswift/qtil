<?php
namespace qtil\Tests\Mock {
    use qtil;
    
    class QueryChainSuffix {
        use qtil\Chain, qtil\ArrayAccess;
        
        const LINK_SUFFIX = 'Item';
        
        public $arg2;
        public $arg1;
        
        function __construct($arg1=null,array $arg2=[]) {
            $this->arg1 = $arg1;
            $this->arg2 = $arg2;
        }
    }
}