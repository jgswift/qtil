<?php
namespace qtil\Tests {
    class ChainSuffixTest extends qtilTestCase {
        function testLinkSuffixBuilding() {
            $query = new Mock\QueryChainSuffix(true);
            
            $query->Select()->From();
            
            $count = count($query->getLinks());
            
            $this->assertEquals(2,$count);
        }
        
        function testLinkSuffixCheck() {
            $query = new Mock\QueryChainSuffix(true);
            
            $this->assertTrue($query->canLink('Select'));
            $this->assertFalse($query->canLink('Order'));
        }
        
        function testLinkSuffixExist() {
            $query = new Mock\QueryChainSuffix(true);
            
            $query->Select()->From();
            
            $exists = $query->hasLink('Select');
            
            $this->assertEquals(true,$exists);
        }
        
        function testLinkSuffixRetrieve() {
            $query = new Mock\QueryChainSuffix(true);
            
            $query->Select()->From();
            
            $select = $query->getLink('Select')[0];
            
            $this->assertInstanceOf('qtil\Tests\Mock\QueryChainSuffix\SelectItem',$select);
        }
        
        /**
         * @expectedException \BadMethodCallException
         */
        function testLinkSuffixBuildAbstractException() {
            $query = new Mock\QueryChainSuffix(true);
            
            $query->Select()->Statement();
        }
    }
}