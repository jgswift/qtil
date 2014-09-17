<?php
namespace qtil\Tests {
    class StringTest extends qtilTestCase {
        function testIsJSON() {
            $json_data = [
                'hello' => 'world'
            ];
            
            $this->assertTrue(\qtil\StringUtil::isJSON(json_encode($json_data)));
        }
        
        function testStartEndsWith() {
            $str = 'hello world';
            
            $this->assertTrue(\qtil\StringUtil::startsWith($str,'hello'));
            
            $this->assertTrue(\qtil\StringUtil::endsWith($str,'world'));
        }
        
        function testStrArray() {
            $str = 'hello:world;billy:bob;';
            
            $arr = \qtil\StringUtil::explodeArray($str);
            
            $this->assertEquals(2,count($arr));
            
            $str2 = \qtil\StringUtil::implodeArray($arr);
            
            $this->assertEquals($str,$str2);
        }
        
        function testArraySearch() {           
            $result = \qtil\StringUtil::strposInArray('bob went to billys to serve jim bob dinner', 'bob');
            
            $this->assertEquals(2,count($result));
        }
        
        function testIsSerial() {
            $obj = new \stdClass();
            
            $str = serialize($obj);
            
            $this->assertTrue(\qtil\StringUtil::isSerial($str));
        }
        
        function testOrdinal() {
            $num = 22;
            
            $ord = \qtil\StringUtil::ordinal($num);
            
            $this->assertEquals('22nd',$ord);
        }
        
        function testPadZero() {
            $num = 34;
            
            $pad = \qtil\StringUtil::padZero($num, 3);
            
            $this->assertEquals('00034',$num);
        }
    }
}