<?php

namespace CodeDistortion\Insight\Tests\Unit;

/**
 * An example testing class that is instantiated for Insight testing.
 */
class SomeClassPrivateConstructor
{
    /**
     * A public property.
     *
     * @var string|null
     */
    public $publicProp = 'Public';

    /**
     * A protected property.
     *
     * @var string|null
     */
    protected $protectedProp = 'Protected';

    /**
     * A private property.
     *
     * @var string|null
     */
    private $privateProp = 'Private';



    /**
     * A public property.
     *
     * @var string|null
     */
    public static $publicStaticProp = 'Public Static';

    /**
     * A protected property.
     *
     * @var string|null
     */
    protected static $protectedStaticProp = 'Protected Static';

    /**
     * A private property.
     *
     * @var string|null
     */
    private static $privateStaticProp = 'Private Static';





    /**
     * SomeClassPrivateConstructor constructor.
     */
    private function __construct()
    {
    }

    /**
     * Handle property accesses when the property doesn't exist.
     *
     * @param string $name The name of the property to get.
     * @return mixed
     */
//    public function __get(string $name)
//    {
//        return $name;
//    }

    /**
     * Handle property accesses when the property doesn't exist.
     *
     * @param string $name  The name of the property to set.
     * @param mixed  $value The value to set.
     * @return void
     */
//    public function __set(string $name, $value)
//    {
//        $this->$name = $value;
//    }



    /**
     * Handle method calls when the method doesn't exist.
     *
     * @param string $name The name of the method called.
     * @param array  $args The arguments to pass to the method.
     * @return mixed
     */
//    public function __call(string $name, array $args)
//    {
//        return $args[0].$args[1];
//    }



    /**
     * Return the static $protectedStaticProp.
     *
     * @return mixed
     */
    public static function getProtectedStaticProp()
    {
        return static::$protectedStaticProp;
    }

    /**
     * Return the static $privateStaticProp.
     *
     * @return mixed
     */
    public static function getPrivateStaticProp()
    {
        return static::$privateStaticProp;
    }

    /**
     * Reset this class' static properties.
     *
     * @return mixed
     */
    public static function resetStaticProps()
    {
        static::$publicStaticProp = 'Public Static';
        static::$protectedStaticProp = 'Protected Static';
        static::$privateStaticProp = 'Private Static';
    }



    /**
     * A public method.
     *
     * @param string $a A parameter.
     * @param string $b A parameter.
     * @return string
     */
    public function publicMethod(string $a, string $b): string
    {
        return $a . $b;
    }

    /**
     * A protected method.
     *
     * @param string $a A parameter.
     * @param string $b A parameter.
     * @return string
     */
    protected function protectedMethod(string $a, string $b): string
    {
        return $a . $b;
    }

    /**
     * A private method.
     *
     * @param string $a A parameter.
     * @param string $b A parameter.
     * @return string
     */
    private function privateMethod(string $a, string $b): string
    {
        return $a . $b;
    }



    /**
     * A public static method.
     *
     * @param string $a A parameter.
     * @param string $b A parameter.
     * @return string
     */
    public static function publicStaticMethod(string $a, string $b): string
    {
        return $a . $b;
    }

    /**
     * A protected static method.
     *
     * @param string $a A parameter.
     * @param string $b A parameter.
     * @return string
     */
    protected static function protectedStaticMethod(string $a, string $b): string
    {
        return $a . $b;
    }

    /**
     * A private static method.
     *
     * @param string $a A parameter.
     * @param string $b A parameter.
     * @return string
     */
    private static function privateStaticMethod(string $a, string $b): string
    {
        return $a . $b;
    }
}
