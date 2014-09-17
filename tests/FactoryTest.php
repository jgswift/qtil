<?php
namespace qtil\Tests {
    class FactoryTest extends qtilTestCase {
        function testObjectCreate() {
            $factory = new Mock\FooFactory;
            
            $queryChain = $factory->make('qtil\Tests\Mock\QueryChain',[true]);
            
            $isQueryChain = $queryChain instanceof Mock\QueryChain;
            
            $this->assertEquals(true,$isQueryChain);
        }
        
        function testAutoloadException() {
            $factory = new Mock\FooFactory;
            
            $null = $factory->make('NonExistantClass');
            
            $this->assertNull($null);
        }
        
        function testObjectConstructorArgumentMismatchException() {
            $factory = new Mock\FooFactory;
            
            $queryChain = $factory->make('qtil\Tests\Mock\QueryChain',[true,[]]);
            
            $this->assertInstanceOf('qtil\Tests\Mock\QueryChain', $queryChain);
            
            $this->assertTrue($queryChain->arg1);
            $this->assertTrue(is_array($queryChain->arg2));
        }
    }
}