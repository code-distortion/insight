# Insight

[![Latest Version on Packagist](https://img.shields.io/packagist/v/code-distortion/insight.svg?style=flat-square)](https://packagist.org/packages/code-distortion/insight)
![PHP from Packagist](https://img.shields.io/packagist/php-v/code-distortion/insight?style=flat-square)
[![GitHub Workflow Status](https://img.shields.io/github/workflow/status/code-distortion/insight/run-tests?label=tests&style=flat-square)](https://github.com/code-distortion/insight/actions)
[![Buy us a tree](https://img.shields.io/badge/treeware-%F0%9F%8C%B3-lightgreen?style=flat-square)](https://offset.earth/treeware?gift-trees)
[![Contributor Covenant](https://img.shields.io/badge/contributor%20covenant-v2.0%20adopted-ff69b4.svg?style=flat-square)](code_of_conduct.md)

Sometimes you have a class you'd like to test and you want to get into more detail than just black-box-testing it's public methods.

***code-distortion/insight*** is a PHP library that allows you to test protected and private object methods and properties as if they were *public*.

``` php
$myObject->privateMethod(); // "Error: Call to private method ..."
$testObject = new Insight($myObject);
$testObject->privateMethod(); // success
```

***Note***: There is ardent [discussion](https://stackoverflow.com/questions/105007/should-i-test-private-methods-or-only-public-ones) on whether testing protected/private code is a good idea. For example, testing this way may give you better code-coverage but will also couple your tests to the internals of your classes which may make refactoring more difficult.

It's up to you where to draw the line. You might want to at least keep tests that use it separate from those that don't.

***Note***: Using Insight for purposes other than testing is a code smell (don't do that).

## Installation

Install the package via composer:

``` bash
composer require code-distortion/insight --dev
```

## Usage

Instantiate an Insight object:

``` php
// build based on an existing object
$myObject = new MyClass();
$testObject = new Insight($myObject);

// or
$testObject = new Insight(new MyClass());
```

$testObject will then act as if it ***is*** the original object, but gives you access to its protected and private methods and properties as well.

Access protected and private properties:

``` php
$testObject->publicProp = 'something';
$testObject->protectedProp = 'something';
$testObject->privateProp = 'something';

print $testObject->publicProp;
print $testObject->protectedProp;
print $testObject->privateProp;
```

Call protected and private methods:

``` php
print $testObject->publicMethod();
print $testObject->protectedMethod();
print $testObject->privateMethod();
```

These can be useful while testing your code with [phpunit](https://github.com/sebastianbergmann/phpunit):

``` php
$this->testSame('someValue', $testObject->privateProperty);
$this->testSame('someValue', $testObject->privateMethod());
```

### Abstract classes

You can test abstract classes (and classes whose constructor is not public) by passing the *class* when instantiating an Insight object.

``` php
$testObject = new Insight(MyClass::class);
```

***Note***: When instantiating Insight with a class like this (instead of an object) you will only be able to access it's *static* methods and properties.

***Note***: To test other functionality of an abstract class you will need to have a concrete class that extends the abstract class, and use that instead.

### Static methods and properties

An Insight object needs to exist for it to know which object or class to give insight into.

eg. it won't be able to work out which class you're referring to when Insight::privateProp or Insight::privateMethod() is used.

(PHP doesn't have *__getStatic()* or *__setStatic()* magic methods either which would help facilitate accessing protected properties).

Instead, Insight lets you access static methods and properties in the same way as regular methods and properties:

``` php
// calling them from an Insight object
$testObject = new Insight(new MyClass());
// or
$testObject = new Insight(MyClass::class);

$testObject->privateStaticProp = 'something';
$testObject->privateStaticMethod();

// this syntax is also available allowing you to access them in one line
Insight::{myClass::class}()->privateStaticProp = 'something';
Insight::{myClass::class}()->privateStaticMethod();
```

### Misc

You can access the underlying object or class by accessing the *->insight* property:

``` php
// when instantiated using an object
$myObject = new MyClass();
$testObject = new Insight($myObject);
$testObject->insight; // === $myObject

// when instantiated using a class name
$testObject = new Insight(MyClass::class);
$testObject->insight; // === 'Namespace\To\MyClass'
```

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

### SemVer

This library uses [SemVer 2.0.0](https://semver.org/) versioning. This means that changes to `X` indicate a breaking change: `0.0.X`, `0.X.y`, `X.y.z`. When this library changes to version 1.0.0, 2.0.0 and so forth it doesn't indicate that it's necessarily a notable release, it simply indicates that the changes were breaking.

## Treeware

You're free to use this package, but if it makes it to your production environment please plant or buy a tree for the world.

It's now common knowledge that one of the best tools to tackle the climate crisis and keep our temperatures from rising above 1.5C is to <a href="https://www.bbc.co.uk/news/science-environment-48870920">plant trees</a>. If you support this package and contribute to the Treeware forest you'll be creating employment for local families and restoring wildlife habitats.

You can buy trees here [offset.earth/treeware](https://offset.earth/treeware?gift-trees)

Read more about Treeware at [treeware.earth](http://treeware.earth)

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Code of conduct

Please see [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

### Security

If you discover any security related issues, please email tim@code-distortion.net instead of using the issue tracker.

## Credits

- [Tim Chandler](https://github.com/code-distortion)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## PHP Package Boilerplate

This package was generated using the [PHP Package Boilerplate](https://laravelpackageboilerplate.com).
