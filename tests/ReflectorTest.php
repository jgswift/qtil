<?php
namespace qtil\Tests {
    use qtil;
    
    class ReflectorTest extends qtilTestCase {
        function testPropertyAccessible() {
            $user = new Mock\User;
            
            $accessible = qtil\ReflectorUtil::propertyAccessible($user, 'password');
            
            $this->assertEquals(false,$accessible);
            
            $accessible = qtil\ReflectorUtil::propertyAccessible($user, 'schemeIdentifiedProperty');
            
            $this->assertEquals(true,$accessible);
        }
        
        function testExtractClassInfo() {
            $result = \qtil\ReflectorUtil::extractClassInfo(self::class);
            $this->assertEquals([
                'qtil',
                'Tests'
            ], $result['namespace']);
            
            $this->assertEquals('ReflectorTest', $result['classname']);
        }
        
        function testGetClassName() {
            $className = \qtil\ReflectorUtil::getClassName(self::class);
            
            $this->assertEquals('ReflectorTest', $className);
        }
        
        function testUsesTrait() {
            $collection = new \qtil\Collection();
            
            $this->assertTrue(\qtil\ReflectorUtil::usesTrait($collection, 'qtil\ArrayEnumerable'));
        }
    }
}