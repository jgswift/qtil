<?php
namespace qtil\Tests {
    use qtil;
    
    class ArrayHandlingTest extends qtilTestCase {
        function testArrayAccessorMutator() {
            $foo = new Mock\FooArrayAccess();
            
            $foo['bar'] = 'baz';
            
            $value = $foo['bar'];
            
            $this->assertEquals('baz',$value);
        }
        
        function testArrayUnset() {
            $foo = new Mock\FooArrayAccess();
            
            $foo['bar'] = 'baz';
            
            unset($foo['bar']);
            
            $count = count($foo);
            
            $this->assertEquals(0,$count);
        }
        
        function testArrayExists() {
            $foo = new Mock\FooArrayAccess();
            
            $foo['bar'] = 'baz';
            
            $value = isset($foo['bar']);
            
            $this->assertEquals(true,$value);
        }
        
        function testArrayConvert() {
            $foo = new Mock\FooArrayAccess();
            
            $foo['bar'] = 'baz';
            
            $array = $foo->toArray();
            
            $isArray = is_array($array);
            $count = count($array);
            
            $this->assertEquals(true,$isArray);
            $this->assertEquals(1,$count);
        }
        
        function testCollectionEquality() {
            $data = [
                'foo' => 'bar'
            ];
            
            $collection1 = new qtil\Collection($data);
            $collection2 = new qtil\Collection($data);
            
            $equal = $collection1->equals($collection2);
            $this->assertEquals(true,$equal);
        }
        
        function testCollectionAdd() {
            $collection = new qtil\Collection();
            
            $collection->add('bar');
            
            $count = count($collection);
            
            $this->assertEquals(1,$count);
        }
        
        function testCollectionInsert() {
            $collection = new qtil\Collection();
            
            $collection->insert('foo','bar');
            
            $value = $collection['foo'];
            $count = count($collection);
            
            $this->assertEquals(1,$count);
            $this->assertEquals('bar',$value);
        }
        
        function testCollectionRemove() {
            $collection = new qtil\Collection();
            
            $collection->insert('foo','bar');
            
            $collection->remove('foo');
            
            $count = count($collection);
            
            $this->assertEquals(0,$count);
        }
        
        function testCollectionExists() {
            $collection = new qtil\Collection();
            
            $collection->insert('foo','bar');
            
            $exists = $collection->exists('foo');
            
            $this->assertEquals(true,$exists);
        }
        
        function testCollectionClear() {
            $collection = new qtil\Collection();
            
            $collection->insert('foo','bar');
            
            $collection->clear();
            
            $count = count($collection);
            
            $this->assertEquals(0,$count);
        }
        
        function testCollectionGlobalAlias() {
            $data1 = ['foo'=>'bar'];
            $data2 = ['baz'=>'bob'];
            
            $result = qtil\ArrayUtil::merge($data1,$data2);
            
            $count = count($result);
            
            $this->assertEquals(2,$count);
        }
        
        function testArrayUtilMulti() {
            $data1 = [
                ['foo'=>'goo']
            ];
            
            $isMulti = qtil\ArrayUtil::isMulti($data1);
            
            $this->assertEquals(true,$isMulti);
        }
        
        function testArrayUtilDiffAssoc() {
            $data1 = [
                'green','red','blue','orange'
            ];
            
            $data2 = [
                'green','blue','yellow'
            ];
            
            $diffArray = qtil\ArrayUtil::diffAssoc($data1,$data2);
            
            $count = count($diffArray);
            
            $this->assertEquals(3,$count);
        }
        
        function testArrayUtilInsertArray() {
            
            $data1 = [
                'red',
                'green',
                'purple'
            ];
            
            $data2 = [
                'orange','blue','yellow'
            ];
            
            $data3 = qtil\ArrayUtil::insertArray($data1,$data2,'green');
            
            $count = count($data3);
            $value = $data3[1];
            
            $this->assertEquals(6,$count);
            $this->assertEquals('orange',$value);
        }
        
        function testArrayJSONConversion() {
            $fooArray = new Mock\FooArrayAccess([
                'foo'=>'bar'
            ]);
            
            $json_string = $fooArray->toJSON();
            $fooArray2 = new Mock\FooArrayAccess();
            $fooArray2->fromJSON($json_string);
            
            $count = count($fooArray2);
            
            $this->assertEquals(1,$count);
        }
    }
}