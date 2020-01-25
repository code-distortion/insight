<?php

namespace CodeDistortion\Insight;

use CodeDistortion\Insight\Exceptions\InsightException;
use ReflectionClass;
use ReflectionException;
use ReflectionObject;

/**
 * Give access to protected and private object properties and methods.
 */
class Insight
{
    /**
     * The instance of the object to give access.
     *
     * @var object|string
     */
    public $insight;

    /**
     * Insight constructor.
     *
     * @param string|object $objectOrClass The object or class to give access into.
     * @throws InsightException Thrown when a given class couldn't be instantiated.
     */
    public function __construct($objectOrClass)
    {
        // store the given object
        if (is_object($objectOrClass)) {
            $this->insight = $objectOrClass;
            return;
        }

        // or treat $objectOrClass as a class name
        if (is_string($objectOrClass)) {

            if (!class_exists($objectOrClass)) {
                throw InsightException::classDoesNotExist($objectOrClass);
            }

            $this->insight = $objectOrClass;
            return;
        }

        throw InsightException::invalidClassOrObject($objectOrClass);
    }



    /**
     * Try to access a property.
     *
     * @param string $name The property to get.
     * @return mixed
     * @throws InsightException Thrown when trying to access a static property that doesn't exist.
     * @throws InsightException Thrown when trying to access a non-static property when the class hasn't been
     *                          instantiated.
     */
    public function __get(string $name)
    {
        $static = is_string($this->insight);
        try { // try-catch to handle the exception for phpstan
            $reflection = ($static
                ? new ReflectionClass($this->insight)
                : new ReflectionObject($this->insight));
        } catch (ReflectionException $e) { // ignore because we know the class exists
            $reflection = null;
        }

        if (($reflection) && ($reflection->hasProperty($name))) {

            try { // try-catch to handle the exception for phpstan
                $prop = $reflection->getProperty($name);
            } catch (ReflectionException $e) { // ignore because it was just confirmed to exist above
                $prop = null;
            }

            if ($prop) {
                if ((!$static) || ($prop->isStatic() == $static)) {
                    $prop->setAccessible(true);
                    return $prop->getValue($this->insight);
                }
                throw InsightException::propMustBeStatic($name);
            }
        }

        // otherwise pass the call on to the object itself
        if (!$static) {
            return $this->insight->{$name};
        }
        throw InsightException::staticPropertyDoesNotExist($name);
    }

    /**
     * Try to set a property.
     *
     * @param string $name  The property to set.
     * @param mixed  $value The value to assign to $name.
     * @return void
     * @throws InsightException Thrown when trying to set a static property that doesn't exist.
     * @throws InsightException Thrown when trying to set a non-static property when the class hasn't been
     *                          instantiated.
     */
    public function __set(string $name, $value)
    {
        $static = is_string($this->insight);
        try { // try-catch to handle the exception for phpstan
            $reflection = ($static
                ? new ReflectionClass($this->insight)
                : new ReflectionObject($this->insight));
        } catch (ReflectionException $e) { // ignore because we know the class exists
            $reflection = null;
        }

        if (($reflection) && ($reflection->hasProperty($name))) {

            try { // try-catch to handle the exception for phpstan
                $prop = $reflection->getProperty($name);
            } catch (ReflectionException $e) { // ignore because it was just confirmed to exist above
                $prop = null;
            }

            if ($prop) {
                if ((!$static) || ($prop->isStatic() == $static)) {
                    $prop->setAccessible(true);
                    $prop->setValue($this->insight, $value);
                    return;
                }
                throw InsightException::propMustBeStatic($name);
            }
        }

        // otherwise pass the call on to the object itself
        if (!$static) {
            $this->insight->{$name} = $value;
            return;
        }
        throw InsightException::staticPropertyDoesNotExist($name);
    }

    /**
     * Try to call the given method.
     *
     * @param string $name The name of the method called.
     * @param array  $args The arguments to pass to the method.
     * @return mixed
     * @throws InsightException Thrown when the method does not exist or there was a problem calling it.
     */
    public function __call(string $name, array $args)
    {
        $static = is_string($this->insight);
        try { // try-catch to handle the exception for phpstan
            $reflection = ($static
                ? new ReflectionClass($this->insight)
                : new ReflectionObject($this->insight));
        } catch (ReflectionException $e) { // ignore because we know the class exists
            $reflection = null;
        }

        if (($reflection) && ($reflection->hasMethod($name))) {

            try { // try-catch to handle the exception for phpstan
                $method = $reflection->getMethod($name);
            } catch (ReflectionException $e) { // ignore because it was just confirmed to exist above
                $method = null;
            }

            if ($method) {
                if ((!$static) || ($method->isStatic() == $static)) {

                    $method->setAccessible(true);
                    return $method->invokeArgs(
                        ($static ? null : $this->insight),
                        $args
                    );
                }
                throw InsightException::methodMustBeStatic($name);
            }
        }

        // otherwise pass the call on to the parent
        if (!$static) {
            $callable = [$this->insight, $name];
            if (is_callable($callable)) {
                return call_user_func_array($callable, $args);
            }
        }
        throw InsightException::staticMethodDoesNotExist($name);
    }

    /**
     * Instantiate an Insight object based on the specified $class.
     *
     * @param string $class The name of the method called (which is the class to assume).
     * @param array  $args  The arguments to pass to the method.
     * @return mixed
     * @throws InsightException Thrown when the method does not exist or there was a problem calling it.
     */
    public static function __callStatic(string $class, array $args)
    {
        if (!class_exists($class)) {
            throw InsightException::classDoesNotExist($class);
        }

        return new Insight($class);
    }
}
