<?php
namespace qtil\Tests {
    class FactoryTest extends qtilTestCase {
        function testObjectCreate() {
            $factory = new Mock\FooFactory;
            
            $queryChain = $factory->build('qtil\Tests\Mock\QueryChain',[true]);
            
            $isQueryChain = $queryChain instanceof Mock\QueryChain;
            
            $this->assertEquals(true,$isQueryChain);
        }
        
        function testAutoloadException() {
            $factory = new Mock\FooFactory;
            
            $queryChain = $factory->build('NonExistantClass');
        }
        
        function testObjectConstructorArgumentMismatchException() {
            $factory = new Mock\FooFactory;
            
            $queryChain = $factory->build('QueryChain',[true,false,true]);
        }
    }
}