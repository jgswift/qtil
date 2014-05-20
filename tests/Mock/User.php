<?php
namespace qtil\Tests\Mock {
    class User implements IdentifierInterface {
        use RoleTrait;
        
        public $schemeIdentifiedProperty;
        private $password;
        
        function getIdentifier() {
            return 1;
        }
        
        function getExtraIdentifier() {
            return 2;
        }
    }
}