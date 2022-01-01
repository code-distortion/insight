<?php

namespace CodeDistortion\Insight\Tests\Unit;

/**
 * An example testing class that is instantiated for Insight testing.
 */
class SomeClassWithMagic
{
    /**
     * Handle property accesses when the property doesn't exist.
     *
     * @param string $name The name of the property to get.
     * @return mixed
     */
    public function __get(string $name)
    {
        return $name;
    }

    /**
     * Handle property accesses when the property doesn't exist.
     *
     * @param string $name  The name of the property to set.
     * @param mixed  $value The value to set.
     * @return void
     */
    public function __set(string $name, $value)
    {
        $this->$name = $value;
    }



    /**
     * Handle method calls when the method doesn't exist.
     *
     * @param string $name The name of the method called.
     * @param array  $args The arguments to pass to the method.
     * @return mixed
     */
    public function __call(string $name, array $args)
    {
        return $args[0] . $args[1];
    }
}
