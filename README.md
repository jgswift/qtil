qtil
====
PHP 5.5+ utility library

[![Build Status](https://travis-ci.org/jgswift/qtil.png?branch=master)](https://travis-ci.org/jgswift/qtil)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/jgswift/qtil/badges/quality-score.png?s=4a9c26bbc7792d7d3e1fec6ad4deee79c836e620)](https://scrutinizer-ci.com/g/jgswift/qtil/)

## Description 

Qtil is a collection of traits and general utilities to assist in development and reduce boilerplate.

## Installation

Install via cli using [composer](https://getcomposer.org/):
```sh
php composer.phar require jgswift/qtil:0.1.*
```

Install via composer.json using [composer](https://getcomposer.org/):
```json
{
    "require": {
        "jgswift/qtil": "0.1.*"
    }
}
```

## Dependency

* php 5.5+

## Usage

### ArrayAccess

The following is an ArrayAccess minimal example
```php
<?php
class Foo implements \ArrayAccess, \Countable, \IteratorAggregate
{
    use qtil\ArrayAccess, qtil\Countable, qtil\IteratorAggregate;
}

$foo = new Foo;
$foo['bar'] = 'baz';
var_dump($foo['bar']); // returns "baz"
```

### ObjectAccess

Much like ArrayAccess, ObjectAccess is available for conventional object magic..

While the following example appears to be default object behavior, all accessors 
and mutators are handled through magic and properties are stored locally in an array

```php
<?php
class Foo
{
    use qtil\ObjectAccess;
}

$foo = new Foo;
$foo->bar = 'baz';
var_dump($foo->bar); // returns "baz"
```

### JSONAccess

The JSONAccess trait provides integrated JSON serialization and may be applied to both ObjectAccess and ArrayAccess objects.

```php
<?php
class Foo
{
    use qtil\ObjectAccess,qtil\JSONAccess;
}

$foo = new Foo;
$foo->bar = 'baz';

$json_string = $foo->toJSON();

$foo2 = new Foo;
$foo2->fromJSON($json_string);

var_dump($foo2->bar); // returns "baz"
```

### Serializable

Normal object serialization is also available using the Serializable interface/trait combination.  Regular serialization is also available to both ArrayAccess and ObjectAccess.

```php
<?php
class Foo implements \Serializable
{
    use qtil\ObjectAccess,qtil\Serializable;
}

$foo = new Foo;
$foo->bar = 'baz';

$serial_string = serialize($foo);

$foo2 = unserialize($serial_string);

var_dump($foo2->bar); // returns "baz"
```

### Iterator

Qtil provides standard Iterator and IteratorAggregate implementations through the traits names Iterator and IteratorAggregate respectively.

```php
<?php
class Foo
{
    use qtil\ObjectAccess,qtil\Iterator;
}

$foo = new Foo;
$foo->bar = 'baz';
$foo->baz = 'rus';

foreach($foo as $name => $value) {
    var_dump($name,$value); // returns bar => baz, then baz => rus
}
```

### IteratorAggregate

```php
<?php
class Foo
{
    use qtil\ObjectAccess,qtil\IteratorAggregate;
}

$foo = new Foo;
$foo->bar = 'baz';
$foo->baz = 'rus';

foreach($foo as $name => $value) {
    var_dump($name,$value); // returns bar => baz, then baz => rus
}
```

### Identifier

Qtil contains a small utility to easily customize how objects are identified.

There are some default schemes for identifying objects that ensures individual object instances are identified respectively.  You can use this functionality instead of spl_object_hash to ensure identifier uniqueness.  Alternatively, a number of built-in schemes are available.

The following is the minimal example, using the default scheme
```php
<?php
class Foo
{

}

$foo = new Foo();
$id = qtil\Identifier::identify($foo); // Returns an unique hash
```

With a minor change, you can encapsulate the identification behavior in your own class

```php
class Foo
{
    function getID() {
        return qtil\Identifier::identify($this);
    }
}

$foo = new Foo();
$id = $foo->getID(); // Returns an unique hash
```

#### Schemes

Alternatively, qtil provides a number of built-in schemes using a variety of ways to determine how to identify an object.

```php
class Foo
{
    function getID() {
        return qtil\Identifier::identify($this);
    }

    function getUniqueID() {
        return 1;
    }
}

qtil\Identifier::addScheme(
    new qtil\Identifier\Scheme\MethodScheme('getUniqueID')
);

$foo = new Foo();
$id = $foo->getID(); // Returns 1
```

You may provide a custom callback method for most schemes

```php
class Foo
{
    function getID() {
        return qtil\Identifier::identify($this);
    }
}

qtil\Identifier::addScheme(
    new qtil\Identifier\Scheme\ClassScheme('Foo',function() {
        return 1;
    })
);

$foo = new Foo();
$id = $foo->getID(); // Returns 1
```

### Factory

Object creation done by Reflection and arguments validated against constructor signature

A *qtil\Exception* is thrown is the given arguments do not match the class constructor

```php
class User {
    /* ... */
}

class MyUserFactory { 
    use qtil\Factory;
}

$factory = new MyUserFactory;
$user = $factory->make('User');

var_dump(get_class($user)); // 'User'

```

### Proxy

Mediates a single objects' local scope through magic methods, namely __get, __set, __unset, __isset, and __call

```php
class MyUserProxy {
    use qtil\Proxy;
}

class User {
    /* ... */

    function sayHello() {
        return 'hello';
    }
}

$user = new User;

$proxy = new MyUserProxy();
$proxy->setSubject($user);

$message = $proxy->sayHello();

var_dump($message); // 'hello'

```

### Executable (Command)

This simple trait makes an object a callable and exposes the call through the execute method.
  The execute method may have any arguments and does not enforce any particular method signature.

```php
class MyBinarySwitch {
    use qtil\Executable;
    
    function execute($start) {
        if($start) {
            return false;
        }
        
        return true;
    }
}

$switch = new MyBinarySwitch();

$result = $switch(false);

var_dump($result); // true
```

### Chain

The chaining mechanism favors convention over configuration.  
The chainable methods are populated by all of the classes in a certain namespace.

The namespace is customizable but defaults to the name of the class.

```php
class Query {
    use qtil\Chain;
}

namespace Query {
    class Select {
        function __construct() {
            /* Specify relevant fields */
        }
    }

    class From {
        function __construct() {
            /* Choose a source */
        }
    }
}

$query = new Query;

$query->select()->from();

var_dump(count($query->getLinks())); // 2

```

Note: any traits that use magic methods such as __get, __set, etc. are not compatible with eachother unless you provide a custom implementation to manually route duplicate methods.  See the [php traits documentation](http://us2.php.net/traits), specifically the insteadof operator.