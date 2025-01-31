<?php

namespace CodeDistortion\Insight\Tests\Unit;

use CodeDistortion\Insight\Exceptions\InsightException;
use CodeDistortion\Insight\Tests\PHPUnitTestCase;
use CodeDistortion\Insight\Insight;
use PHPUnit\Framework\Attributes\Test;
use CodeDistortion\Insight\Tests\Unit\Support\SomeClass;
use CodeDistortion\Insight\Tests\Unit\Support\SomeClassAbstract;
use CodeDistortion\Insight\Tests\Unit\Support\SomeClassPrivateConstructor;
use CodeDistortion\Insight\Tests\Unit\Support\SomeClassWithMagic;

/**
 * Test the Insight class.
 *
 * @phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
 */
class InsightUnitTest extends PHPUnitTestCase
{
    /**
     * Test that Insight can be instantiated when given a closs.
     *
     * @test
     *
     * @return void
     */
    #[Test]
    public function test_insight_can_instantiate_from_class()
    {
        $insight = new Insight(SomeClass::class);
        self::assertSame(SomeClass::class, $insight->insight);

        $caughtException = false;
        try {
            new Insight('abc');
        } catch (InsightException $e) {
            $caughtException = true;
        }
        self::assertTrue($caughtException);

        $caughtException = false;
        try {
            new Insight(true); // @phpstan-ignore-line
        } catch (InsightException $e) {
            $caughtException = true;
        }
        self::assertTrue($caughtException);
    }

    /**
     * Test that Insight can be instantiated when given an object.
     *
     * @test
     *
     * @return void
     */
    #[Test]
    public function test_insight_can_instantiate_from_object()
    {
        $object = new SomeClass('Public Inst', 'Protected Inst', 'Private Inst');
        $insight = new Insight($object);

        self::assertSame($object, $insight->insight);
    }

    /**
     * Test that Insight can access an object's properties.
     *
     * @test
     *
     * @return void
     */
    #[Test]
    public function test_insight_can_access_properties()
    {
        $object = new SomeClass('Public Inst', 'Protected Inst', 'Private Inst');
        $insight = new Insight($object);



        self::assertSame('Public Inst', $insight->publicProp);
        $insight->publicProp = 'Public NEW!';
        self::assertSame('Public NEW!', $insight->publicProp);

        $caughtException = false;
        try {
            (new Insight(SomeClass::class))->publicProp;
        } catch (InsightException $e) {
            $caughtException = true;
        }
        self::assertTrue($caughtException);

        $caughtException = false;
        try {
            Insight::{SomeClass::class}()->publicProp;
        } catch (InsightException $e) {
            $caughtException = true;
        }
        self::assertTrue($caughtException);



        self::assertSame('Protected Inst', $insight->protectedProp);
        $insight->protectedProp = 'Protected NEW!';
        self::assertSame('Protected NEW!', $insight->protectedProp);

        $caughtException = false;
        try {
            (new Insight(SomeClass::class))->protectedProp;
        } catch (InsightException $e) {
            $caughtException = true;
        }
        self::assertTrue($caughtException);

        $caughtException = false;
        try {
            Insight::{SomeClass::class}()->protectedProp;
        } catch (InsightException $e) {
            $caughtException = true;
        }
        self::assertTrue($caughtException);



        self::assertSame('Private Inst', $insight->privateProp);
        $insight->privateProp = 'Private NEW!';
        self::assertSame('Private NEW!', $insight->privateProp);

        $caughtException = false;
        try {
            (new Insight(SomeClass::class))->privateProp;
        } catch (InsightException $e) {
            $caughtException = true;
        }
        self::assertTrue($caughtException);

        $caughtException = false;
        try {
            Insight::{SomeClass::class}()->privateProp;
        } catch (InsightException $e) {
            $caughtException = true;
        }
        self::assertTrue($caughtException);



//        self::assertSame('missingProp', $insight->missingProp);
//        $insight->missingProp = 'found';
//        self::assertSame('found', $insight->missingProp);

        $caughtException = false;
        try {
            (new Insight(SomeClass::class))->missingProp;
        } catch (InsightException $e) {
            $caughtException = true;
        }
        self::assertTrue($caughtException);

        $caughtException = false;
        try {
            Insight::{SomeClass::class}()->missingProp;
        } catch (InsightException $e) {
            $caughtException = true;
        }
        self::assertTrue($caughtException);



        SomeClass::resetStaticProps();
        self::assertSame('Public Static', $insight->publicStaticProp);
        self::assertSame('Public Static', (new Insight(SomeClass::class))->publicStaticProp);
        self::assertSame('Public Static', Insight::{SomeClass::class}()->publicStaticProp);
        $insight->publicStaticProp = 'Public Static NEW!';
        self::assertSame('Public Static NEW!', $insight->publicStaticProp);
        self::assertSame('Public Static NEW!', (new Insight(SomeClass::class))->publicStaticProp);
        self::assertSame('Public Static NEW!', Insight::{SomeClass::class}()->publicStaticProp);

        SomeClass::resetStaticProps();
        self::assertSame('Public Static', $insight->publicStaticProp);
        self::assertSame('Public Static', (new Insight(SomeClass::class))->publicStaticProp);
        self::assertSame('Public Static', Insight::{SomeClass::class}()->publicStaticProp);
        Insight::{SomeClass::class}()->publicStaticProp = 'Public Static NEW!';
        self::assertSame('Public Static NEW!', $insight->publicStaticProp);
        self::assertSame('Public Static NEW!', (new Insight(SomeClass::class))->publicStaticProp);
        self::assertSame('Public Static NEW!', Insight::{SomeClass::class}()->publicStaticProp);



        SomeClass::resetStaticProps();
        self::assertSame('Protected Static', $insight->protectedStaticProp);
        self::assertSame('Protected Static', (new Insight(SomeClass::class))->protectedStaticProp);
        self::assertSame('Protected Static', Insight::{SomeClass::class}()->protectedStaticProp);
        $insight->protectedStaticProp = 'Protected Static NEW!';
        self::assertSame('Protected Static NEW!', $insight->protectedStaticProp);
        self::assertSame('Protected Static NEW!', (new Insight(SomeClass::class))->protectedStaticProp);
        self::assertSame('Protected Static NEW!', Insight::{SomeClass::class}()->protectedStaticProp);

        SomeClass::resetStaticProps();
        self::assertSame('Protected Static', $insight->protectedStaticProp);
        self::assertSame('Protected Static', (new Insight(SomeClass::class))->protectedStaticProp);
        self::assertSame('Protected Static', Insight::{SomeClass::class}()->protectedStaticProp);
        Insight::{SomeClass::class}()->protectedStaticProp = 'Protected Static NEW!';
        self::assertSame('Protected Static NEW!', $insight->protectedStaticProp);
        self::assertSame('Protected Static NEW!', (new Insight(SomeClass::class))->protectedStaticProp);
        self::assertSame('Protected Static NEW!', Insight::{SomeClass::class}()->protectedStaticProp);



        SomeClass::resetStaticProps();
        self::assertSame('Private Static', $insight->privateStaticProp);
        self::assertSame('Private Static', (new Insight(SomeClass::class))->privateStaticProp);
        self::assertSame('Private Static', Insight::{SomeClass::class}()->privateStaticProp);
        $insight->privateStaticProp = 'Private Static NEW!';
        self::assertSame('Private Static NEW!', $insight->privateStaticProp);
        self::assertSame('Private Static NEW!', (new Insight(SomeClass::class))->privateStaticProp);
        self::assertSame('Private Static NEW!', Insight::{SomeClass::class}()->privateStaticProp);

        SomeClass::resetStaticProps();
        self::assertSame('Private Static', $insight->privateStaticProp);
        self::assertSame('Private Static', (new Insight(SomeClass::class))->privateStaticProp);
        self::assertSame('Private Static', Insight::{SomeClass::class}()->privateStaticProp);
        Insight::{SomeClass::class}()->privateStaticProp = 'Private Static NEW!';
        self::assertSame('Private Static NEW!', $insight->privateStaticProp);
        self::assertSame('Private Static NEW!', (new Insight(SomeClass::class))->privateStaticProp);
        self::assertSame('Private Static NEW!', Insight::{SomeClass::class}()->privateStaticProp);




        // test that property access is passed to the $object
        $insight = new Insight(new SomeClassWithMagic());
        self::assertSame('missingProp', $insight->missingProp);
        self::assertSame('I exist', $insight->existingProp);
        $insight->existingProp = 'Yes I do';
        self::assertSame('Yes I do', $insight->existingProp);
    }

    /**
     * Test that Insight can call an object / classes' methods.
     *
     * @test
     *
     * @return void
     */
    #[Test]
    public function test_insight_can_call_methods()
    {
        $sources = [
            new SomeClass('Public Inst', 'Protected Inst', 'Private Inst'),
            SomeClassAbstract::class,
            SomeClassPrivateConstructor::class,
        ];
        foreach ($sources as $source) {

            $insight = new Insight($source);

            if (is_object($source)) {

                self::assertSame('ab', $insight->publicMethod('a', 'b'));
                self::assertSame('ab', $insight->protectedMethod('a', 'b'));
                self::assertSame('ab', $insight->privateMethod('a', 'b'));
//                self::assertSame('ab', $insight->missingMethod('a', 'b'));

            } else {

                $caughtException = false;
                try {
                    $insight->publicMethod('a', 'b');
                } catch (InsightException $e) {
                    $caughtException = true;
                }
                self::assertTrue($caughtException);

                $caughtException = false;
                try {
                    $insight->protectedMethod('a', 'b');
                } catch (InsightException $e) {
                    $caughtException = true;
                }
                self::assertTrue($caughtException);

                $caughtException = false;
                try {
                    $insight->privateMethod('a', 'b');
                } catch (InsightException $e) {
                    $caughtException = true;
                }
                self::assertTrue($caughtException);

                $caughtException = false;
                try {
                    $insight->missingMethod('a', 'b');
                } catch (InsightException $e) {
                    $caughtException = true;
                }
                self::assertTrue($caughtException);
            }

            self::assertSame('ab', $insight->publicStaticMethod('a', 'b'));
            self::assertSame('ab', $insight->protectedStaticMethod('a', 'b'));
            self::assertSame('ab', $insight->privateStaticMethod('a', 'b'));
        }



        // test that method calling is passed to the $object if the method isn't found
        $insight = new Insight(new SomeClassWithMagic());
        self::assertSame('ab', $insight->missingMethod('a', 'b'));
    }
}
