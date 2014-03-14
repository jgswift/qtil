<?php
namespace qtil\Tests {
    class ProxyTest extends qtilTestCase {
        function testProxyAcessorMutatorMagic() {
            $fooProxy = new Mock\FooProxy();
            
            $subject = new \stdClass();
            
            $fooProxy->setSubject($subject);
            
            $fooProxy->foo = 'bar';
            
            $this->assertEquals('bar',$subject->foo);
        }
        
        function testProxyIssetMagic() {
            $fooProxy = new Mock\FooProxy();
            
            $subject = new \stdClass();
            
            $fooProxy->setSubject($subject);
            
            $fooProxy->foo = 'bar';
            
            $isset = isset($fooProxy->foo);
            
            $this->assertEquals(true,$isset);
        }
        
        function testProxyUnsetMagic() {
            $fooProxy = new Mock\FooProxy();
            
            $subject = new \stdClass();
            
            $fooProxy->setSubject($subject);
            
            $fooProxy->foo = 'bar';
            
            unset($fooProxy->foo);
            
            $isset = isset($fooProxy->foo);
            
            $this->assertEquals(false,$isset);
        }
        
        function testProxyCallMagic() {
            $fooProxy = new Mock\FooProxy();
            
            $subject = new Mock\FooProxySubject();
            
            $fooProxy->setSubject($subject);
            
            $result = $fooProxy->testMethod();
            
            $this->assertEquals('bar',$result);
        }
    }
}