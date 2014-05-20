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
    }
}