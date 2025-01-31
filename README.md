# Insight

[![Latest Version on Packagist](https://img.shields.io/packagist/v/code-distortion/insight.svg?style=flat-square)](https://packagist.org/packages/code-distortion/insight)
![PHP Version](https://img.shields.io/badge/PHP-7.0%20to%208.4-blue?style=flat-square)
[![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/code-distortion/insight/run-tests.yml?branch=master&style=flat-square)](https://github.com/code-distortion/insight/actions)
[![Buy The World a Tree](https://img.shields.io/badge/treeware-%F0%9F%8C%B3-lightgreen?style=flat-square)](https://plant.treeware.earth/code-distortion/insight)
[![Contributor Covenant](https://img.shields.io/badge/contributor%20covenant-v2.1%20adopted-ff69b4.svg?style=flat-square)](.github/CODE_OF_CONDUCT.md)

***code-distortion/insight*** is a PHP library that allows you to access ***protected*** and ***private*** object methods and properties, as if they were ***public***.

``` php
$myObject->privateMethod();   // "Error: Call to private method ..."

$testObject = new Insight($myObject);
$testObject->privateMethod(); // success
```

This might be useful when testing. [It might be a good idea, or it might not](https://stackoverflow.com/questions/105007/should-i-test-private-methods-or-only-public-ones). It's up to you.

> ***Note***: Using Insight for purposes other than testing is probably a code smell.



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

`$testObject` will then act as if it ***is*** the original object, but gives you access to its protected and private methods and properties as well.

Read and write protected and private properties:

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

> ***Note***: When instantiating Insight with a class like this (instead of an object) you will only be able to access it's *static* methods and properties.

> ***Note***: To test other functionality of an abstract class you will need to have a concrete class that extends the abstract class, and use that instead.



### Static methods and properties

PHP doesn't have `__getStatic()` or `__setStatic()` magic methods either which would help facilitate accessing protected properties.

Instead, Insight lets you access static methods and properties in the same way as regular methods and properties. Just add `StaticProp` or `StaticMethod` after the property or method name respectively:

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

You can access the underlying object or class by accessing the `->insight` property:

``` php
// when instantiated using an object
$myObject = new MyClass();
$testObject = new Insight($myObject);
$testObject->insight; // === $myObject

// when instantiated using a class name
$testObject = new Insight(MyClass::class);
$testObject->insight; // === 'Namespace\To\MyClass'
```



## Testing This Package

- Clone this package: `git clone https://github.com/code-distortion/insight.git .`
- Run `composer install` to install dependencies
- Run the tests: `composer test`



## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.



### SemVer

This library uses [SemVer 2.0.0](https://semver.org/) versioning. This means that changes to `X` indicate a breaking change: `0.0.X`, `0.X.y`, `X.y.z`. When this library changes to version 1.0.0, 2.0.0 and so forth, it doesn't indicate that it's necessarily a notable release, it simply indicates that the changes were breaking.



## Treeware

This package is [Treeware](https://treeware.earth). If you use it in production, then we ask that you [**buy the world a tree**](https://plant.treeware.earth/code-distortion/insight) to thank us for our work. By contributing to the Treeware forest you’ll be creating employment for local families and restoring wildlife habitats.



## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.



### Code of Conduct

Please see [CODE_OF_CONDUCT](.github/CODE_OF_CONDUCT.md) for details.



### Security

If you discover any security related issues, please email tim@code-distortion.net instead of using the issue tracker.



## Credits

- [Tim Chandler](https://github.com/code-distortion)



## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
