qtil
====
PHP 5.5+ utility library

[![Build Status](https://travis-ci.org/jgswift/qtil.png?branch=master)](https://travis-ci.org/jgswift/qtil)

## Installation

Install via [composer](https://getcomposer.org/):
```sh
php composer.phar require jgswift/qtil:dev-master
```

## Usage

Qtil is a collection of traits and general utilities to assist in development and over-all reduce boilerplate.

Note: using the traits provided in this package may impact performance for cpu intensive operations.

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

Qtil provides standard Iterator and IteratorAggregate implementations through the traits names Iterator and IteratorAggregate respectively.

Iterator
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

IteratorAggregate
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

Note: qtil additionally provides implementations for several standard design patterns such as Factory, Proxy, Command, and Method Chaining.  Please consult unit tests for implementation details.

Note: any traits that use magic methods such as __get, __set, etc. are not compatible with eachother unless you provide a custom implementation to manually route duplicate methods.  See the [php traits documentation](http://us2.php.net/traits), specifically the insteadof operator.