<?php

namespace CodeDistortion\Insight\Exceptions;

use Exception;

/**
 * The main Insight exception class
 */
class InsightException extends Exception
{
    /**
     * Return a new instance when a given class does not exist.
     *
     * @param string $name The class name that doesn't exist.
     * @return static
     */
    public static function classDoesNotExist(string $name): self
    {
        return new static('Class "'.$name.'" does not exist');
    }

    /**
     * Return a new instance when something other than an object or class were given.
     *
     * @param string $name The $objectOrClass that was given.
     * @return static
     */
    public static function invalidClassOrObject(string $name): self
    {
        return new static('Invalid object or class "'.$name.'"');
    }

    /**
     * Return a new instance when a property was accessed but the object hasn't been instantiated.
     *
     * @param string $name The property that was accessed.
     * @return static
     */
    public static function propMustBeStatic(string $name): self
    {
        return new static('Property "'.$name.'" must be static, or accessed from Insight based on an object instance');
    }

    /**
     * Return a new instance when a property was accessed but it doesn't exist.
     *
     * @param string $name The property that was accessed.
     * @return static
     */
    public static function staticPropertyDoesNotExist(string $name): self
    {
        return new static('Static property "'.$name.'" does not exist');
    }

    /**
     * Return a new instance when a non-static method was called but the object hasn't been instantiated.
     *
     * @param string $name The method that was called.
     * @return static
     */
    public static function methodMustBeStatic(string $name): self
    {
        return new static('Method "'.$name.'" must be static, or called on Insight based on an object instance');
    }

    /**
     * Return a new instance when a method was called but it doesn't exist.
     *
     * @param string $name The method that does not exist.
     * @return static
     */
    public static function staticMethodDoesNotExist(string $name): self
    {
        return new static('Method "'.$name.'" does not exist');
    }
}
