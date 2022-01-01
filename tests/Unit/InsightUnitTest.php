<?php

namespace CodeDistortion\Insight\Tests\Unit;

use CodeDistortion\Insight\Exceptions\InsightException;
use CodeDistortion\Insight\Tests\TestCase;
use CodeDistortion\Insight\Insight;

/**
 * Test the Insight class.
 *
 * @phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
 */
class InsightUnitTest extends TestCase
{
    /**
     * Test that Insight can be instantiated when given a closs.
     *
     * @test
     * @return void
     */
    public function test_insight_can_instantiate_from_class()
    {
        $insight = new Insight(SomeClass::class);
        $this->assertSame(SomeClass::class, $insight->insight);

        $this->assertThrows(InsightException::class, function () {
            new Insight('abc');
        });
        $this->assertThrows(InsightException::class, function () {
            new Insight(true);
        });
    }

    /**
     * Test that Insight can be instantiated when given an object.
     *
     * @test
     * @return void
     */
    public function test_insight_can_instantiate_from_object()
    {
        $object = new SomeClass('Public Inst', 'Protected Inst', 'Private Inst');
        $insight = new Insight($object);

        $this->assertSame($object, $insight->insight);
    }

    /**
     * Test that Insight can access an object's properties.
     *
     * @test
     * @return void
     */
    public function test_insight_can_access_properties()
    {
        $object = new SomeClass('Public Inst', 'Protected Inst', 'Private Inst');
        $insight = new Insight($object);



        $this->assertSame('Public Inst', $insight->publicProp);
        $insight->publicProp = 'Public NEW!';
        $this->assertSame('Public NEW!', $insight->publicProp);

        $this->assertThrows(InsightException::class, function () {
            (new Insight(SomeClass::class))->publicProp;
        });
        $this->assertThrows(InsightException::class, function () {
            Insight::{SomeClass::class}()->publicProp;
        });



        $this->assertSame('Protected Inst', $insight->protectedProp);
        $insight->protectedProp = 'Protected NEW!';
        $this->assertSame('Protected NEW!', $insight->protectedProp);

        $this->assertThrows(InsightException::class, function () {
            (new Insight(SomeClass::class))->protectedProp;
        });
        $this->assertThrows(InsightException::class, function () {
            Insight::{SomeClass::class}()->protectedProp;
        });



        $this->assertSame('Private Inst', $insight->privateProp);
        $insight->privateProp = 'Private NEW!';
        $this->assertSame('Private NEW!', $insight->privateProp);

        $this->assertThrows(InsightException::class, function () {
            (new Insight(SomeClass::class))->privateProp;
        });
        $this->assertThrows(InsightException::class, function () {
            Insight::{SomeClass::class}()->privateProp;
        });



//        $this->assertSame('missingProp', $insight->missingProp);
//        $insight->missingProp = 'found';
//        $this->assertSame('found', $insight->missingProp);

        $this->assertThrows(InsightException::class, function () {
            (new Insight(SomeClass::class))->missingProp;
        });
        $this->assertThrows(InsightException::class, function () {
            Insight::{SomeClass::class}()->missingProp;
        });



        SomeClass::resetStaticProps();
        $this->assertSame('Public Static', $insight->publicStaticProp);
        $this->assertSame('Public Static', (new Insight(SomeClass::class))->publicStaticProp);
        $this->assertSame('Public Static', Insight::{SomeClass::class}()->publicStaticProp);
        $insight->publicStaticProp = 'Public Static NEW!';
        $this->assertSame('Public Static NEW!', $insight->publicStaticProp);
        $this->assertSame('Public Static NEW!', (new Insight(SomeClass::class))->publicStaticProp);
        $this->assertSame('Public Static NEW!', Insight::{SomeClass::class}()->publicStaticProp);

        SomeClass::resetStaticProps();
        $this->assertSame('Public Static', $insight->publicStaticProp);
        $this->assertSame('Public Static', (new Insight(SomeClass::class))->publicStaticProp);
        $this->assertSame('Public Static', Insight::{SomeClass::class}()->publicStaticProp);
        Insight::{SomeClass::class}()->publicStaticProp = 'Public Static NEW!';
        $this->assertSame('Public Static NEW!', $insight->publicStaticProp);
        $this->assertSame('Public Static NEW!', (new Insight(SomeClass::class))->publicStaticProp);
        $this->assertSame('Public Static NEW!', Insight::{SomeClass::class}()->publicStaticProp);



        SomeClass::resetStaticProps();
        $this->assertSame('Protected Static', $insight->protectedStaticProp);
        $this->assertSame('Protected Static', (new Insight(SomeClass::class))->protectedStaticProp);
        $this->assertSame('Protected Static', Insight::{SomeClass::class}()->protectedStaticProp);
        $insight->protectedStaticProp = 'Protected Static NEW!';
        $this->assertSame('Protected Static NEW!', $insight->protectedStaticProp);
        $this->assertSame('Protected Static NEW!', (new Insight(SomeClass::class))->protectedStaticProp);
        $this->assertSame('Protected Static NEW!', Insight::{SomeClass::class}()->protectedStaticProp);

        SomeClass::resetStaticProps();
        $this->assertSame('Protected Static', $insight->protectedStaticProp);
        $this->assertSame('Protected Static', (new Insight(SomeClass::class))->protectedStaticProp);
        $this->assertSame('Protected Static', Insight::{SomeClass::class}()->protectedStaticProp);
        Insight::{SomeClass::class}()->protectedStaticProp = 'Protected Static NEW!';
        $this->assertSame('Protected Static NEW!', $insight->protectedStaticProp);
        $this->assertSame('Protected Static NEW!', (new Insight(SomeClass::class))->protectedStaticProp);
        $this->assertSame('Protected Static NEW!', Insight::{SomeClass::class}()->protectedStaticProp);



        SomeClass::resetStaticProps();
        $this->assertSame('Private Static', $insight->privateStaticProp);
        $this->assertSame('Private Static', (new Insight(SomeClass::class))->privateStaticProp);
        $this->assertSame('Private Static', Insight::{SomeClass::class}()->privateStaticProp);
        $insight->privateStaticProp = 'Private Static NEW!';
        $this->assertSame('Private Static NEW!', $insight->privateStaticProp);
        $this->assertSame('Private Static NEW!', (new Insight(SomeClass::class))->privateStaticProp);
        $this->assertSame('Private Static NEW!', Insight::{SomeClass::class}()->privateStaticProp);

        SomeClass::resetStaticProps();
        $this->assertSame('Private Static', $insight->privateStaticProp);
        $this->assertSame('Private Static', (new Insight(SomeClass::class))->privateStaticProp);
        $this->assertSame('Private Static', Insight::{SomeClass::class}()->privateStaticProp);
        Insight::{SomeClass::class}()->privateStaticProp = 'Private Static NEW!';
        $this->assertSame('Private Static NEW!', $insight->privateStaticProp);
        $this->assertSame('Private Static NEW!', (new Insight(SomeClass::class))->privateStaticProp);
        $this->assertSame('Private Static NEW!', Insight::{SomeClass::class}()->privateStaticProp);




        // test that method calling is passed to the $object if the method isn't found
        $insight = new Insight(new SomeClassWithMagic());
        $this->assertSame('missingProp', $insight->missingProp);
        $insight->missingProp = 'found';
        $this->assertSame('found', $insight->missingProp);
    }

    /**
     * Test that Insight can call an object / classes' methods.
     *
     * @test
     * @return void
     */
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

                $this->assertSame('ab', $insight->publicMethod('a', 'b'));
                $this->assertSame('ab', $insight->protectedMethod('a', 'b'));
                $this->assertSame('ab', $insight->privateMethod('a', 'b'));
//                $this->assertSame('ab', $insight->missingMethod('a', 'b'));

            } else {

                $this->assertThrows(InsightException::class, function () use ($insight) {
                    $insight->publicMethod('a', 'b');
                });
                $this->assertThrows(InsightException::class, function () use ($insight) {
                    $insight->protectedMethod('a', 'b');
                });
                $this->assertThrows(InsightException::class, function () use ($insight) {
                    $insight->privateMethod('a', 'b');
                });
                $this->assertThrows(InsightException::class, function () use ($insight) {
                    $insight->missingMethod('a', 'b');
                });
            }

            $this->assertSame('ab', $insight->publicStaticMethod('a', 'b'));
            $this->assertSame('ab', $insight->protectedStaticMethod('a', 'b'));
            $this->assertSame('ab', $insight->privateStaticMethod('a', 'b'));
        }



        // test that method calling is passed to the $object if the method isn't found
        $insight = new Insight(new SomeClassWithMagic());
        $this->assertSame('ab', $insight->missingMethod('a', 'b'));
    }
}
