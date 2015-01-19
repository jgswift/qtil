<?php
namespace qtil\Tests {
    class ChainTest extends qtilTestCase {
        function testLinkBuilding() {
            $query = new Mock\QueryChain(true);
            
            $query->Select()->From();
            
            $count = count($query->getLinks());
            
            $this->assertEquals(2,$count);
        }
        
        function testLinkCheck() {
            $query = new Mock\QueryChain(true);
            
            $this->assertTrue($query->canLink('Select'));
            $this->assertFalse($query->canLink('Order'));
        }
        
        function testLinkExist() {
            $query = new Mock\QueryChain(true);
            
            $query->Select()->From();
            
            $exists = $query->hasLink('Select');
            
            $this->assertEquals(true,$exists);
        }
        
        function testLinkRetrieve() {
            $query = new Mock\QueryChain(true);
            
            $query->Select()->From();
            
            $select = $query->getLink('Select')[0];
            
            $this->assertInstanceOf('qtil\Tests\Mock\QueryChain\Select',$select);
        }
        
        function testMultipleNamespaceDefinitions() {
            $query = new Mock\QueryChain(true);
            $query->registerNamespace('qtil\Tests\Mock\ExtendedQueryChain');
            
            $query->Select()->From()->Join();
            
            $count = count($query->getLinks());
            
            $this->assertEquals(3,$count);
        }
        
        /**
         * @expectedException \qtil\Factory\ClassNotFoundException
         */
        function testLinkBuildAbstractException() {
            $query = new Mock\QueryChain(true);
            
            $query->Select()->Statement();
        }
        
        function testGlobalChainRegistry() {
            $query = new Mock\QueryChain(true);
            
            \qtil\Chain\ClassRegistry::addNamespace('qtil\Tests\Mock\QueryChain', 'qtil\Tests\Mock\ExtendedQueryChain');
            
            $query->Select()->From()->Join();
            
            $count = count($query->getLinks());
            
            $this->assertEquals(3,$count);
        }
    }
}