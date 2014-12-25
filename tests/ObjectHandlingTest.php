<?php
namespace qtil\Tests {
    class ObjectHandlingTest extends qtilTestCase {
        function testObjectAccessorMutatorMagic() {
            $fooObject = new Mock\FooObjectAccess();
            
            $fooObject->foo = 'bar';
            
            $value = $fooObject->foo;
            
            $this->assertEquals('bar',$value);
        }
        
        function testObjectAccessIssetMagic() {
            $fooObject = new Mock\FooObjectAccess();
            
            $fooObject->foo = 'bar';
            
            $value = isset($fooObject->foo);
            
            $this->assertEquals(true,$value);
        }
        
        function testObjectAccessUnsetMagic() {
            $fooObject = new Mock\FooObjectAccess();
            
            $fooObject->foo = 'bar';
            
            unset($fooObject->foo);
            
            $value = isset($fooObject->foo);
            
            $this->assertEquals(false,$value);
        }
        
        function testExecutableExecution() {
            $fooExecutable = new Mock\FooExecutable;
            
            $value = $fooExecutable();
            
            $this->assertEquals('bar',$value);
        }
        
        function testObjectSerialization() {
            $fooObject = new Mock\FooObjectAccess();
            
            $fooObject->foo = 'bar';
            
            $serial_string = serialize($fooObject);
            
            $fooObject2 = unserialize($serial_string);
            
            $value =  $fooObject2->foo;
            
            $this->assertEquals('bar',$value);
        }
        
        function testIteratorIteration() {
            $fooIterator = new Mock\FooIterator(['bar']);
            
            $count = 0;
            
            foreach($fooIterator as $k=>$v) {
                $this->assertEquals('bar',$v);
                $count++;
            }
            
            $this->assertEquals(1,$count);
        }
        
        function testIteratorAggregate() {
            $fooIteratorAggregate = new Mock\FooIteratorAggregate();
            
            $count = 0;
            
            foreach($fooIteratorAggregate as $k => $v) {
                $count++;
                $this->assertEquals('foo',$k);
                $this->assertEquals('bar',$v);
            }
            
            $this->assertEquals(1,$count);
        }
    }
}