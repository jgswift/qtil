<?php
namespace qtil\Tests {
    use qtil\Identifier;
    
    class IdentifierTest extends qtilTestCase {
        function testDefaultScheme() {
            $object = new \stdClass();
            $id = Identifier::identify($object);
            $id2 = Identifier::identify($object);
            
            $this->assertEquals($id,$id2);
        }
        
        function testTraitScheme() {
            $scheme = new Identifier\TraitScheme('qtil\Tests\Mock\RoleTrait',function($sender) {
                return 1;
            });
            
            Identifier::addScheme($scheme);
            
            $user = new Mock\User();
            $id = Identifier::identify($user);
            $this->assertEquals($id,1);
        }
        
        function testPropertyScheme() {
            $scheme = new Identifier\PropertyScheme(
                'schemeIdentifiedProperty',
                function($sender) {
                    return 1;
                }
            );
            
            Identifier::addScheme($scheme);
            
            $user = new Mock\User();
            $id = Identifier::identify($user);
            $this->assertEquals($id,1);
        }
        
        function testNamespaceScheme() {
            $scheme = new Identifier\NamespaceScheme(
                'qtil\Tests\Mock',
                function($sender) {
                    return 1;
                }
            );
            
            Identifier::addScheme($scheme);
            
            $user = new Mock\User();
            $id = Identifier::identify($user);
            $this->assertEquals($id,1);
        }
        
        function testMethodScheme() {
            $scheme = new Identifier\MethodScheme('getIdentifier');
            
            Identifier::addScheme($scheme);
            
            $user = new Mock\User();
            $id = Identifier::identify($user);
            $this->assertEquals($id,1);
        }
        
        /**
         * @expectedException qtil\Exception
         */
        function testMultipleMethodSchemeException() {
            $scheme = new Identifier\MethodScheme([
                'getIdentifier',
                'getExtraIdentifier'
            ]);
            
            Identifier::addScheme($scheme);
            
            $user = new Mock\User();
            Identifier::identify($user);
        }
        
        function testInterfaceScheme() {
            $scheme = new Identifier\InterfaceScheme(
                'qtil\Tests\Mock\IdentifierInterface',
                'getIdentifier'
            );
            
            Identifier::addScheme($scheme);
            
            $user = new Mock\User();
            $id = Identifier::identify($user);
            $this->assertEquals($id,1);
        }
        
        function testClassScheme() {
            $scheme = new Identifier\ClassScheme(
                'qtil\Tests\Mock\User',
                'getIdentifier'
            );
            
            Identifier::addScheme($scheme);
            
            $user = new Mock\User();
            $id = Identifier::identify($user);
            $this->assertEquals($id,1);
        }
    }
}