<?php
namespace qtil\Tests {
    class ChainTest extends qtilTestCase {
        function testLinkBuilding() {
            $query = new Mock\QueryChain(true);
            
            $query->Select()->From();
            
            $count = count($query->getLinks());
            
            $this->assertEquals(2,$count);
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
            
            $isSelect = $select instanceof Mock\QueryChain\Select;
            
            $this->assertEquals(true,$isSelect);
        }
        
        /**
         * @expectedException qtil\Exception
         */
        function testLinkBuildAbstractException() {
            $query = new Mock\QueryChain(true);
            
            $query->Select()->Statement();
        }
    }
}