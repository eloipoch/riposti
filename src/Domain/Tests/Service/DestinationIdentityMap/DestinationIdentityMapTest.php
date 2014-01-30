<?php

namespace Pablodip\Riposti\Domain\Tests\Service\DestinationIdentityMap;

use Pablodip\Riposti\Domain\Service\DestinationIdentityMap\DestinationIdentityMap;

class DestinationIdentityMapTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function test_it()
    {
        $fooA = new \stdClass();
        $fooB = new \stdClass();
        $barA = new \stdClass();

        $dip = new DestinationIdentityMap();

        $this->assertFalse($dip->has('foo', 'a'));
        $this->assertFalse($dip->has('bar', 'a'));
        $dip->set('foo', 'a', $fooA);
        $this->assertTrue($dip->has('foo', 'a'));
        $this->assertFalse($dip->has('bar', 'a'));
        $this->assertSame($fooA, $dip->get('foo', 'a'));
        try {
            $dip->get('bar', 'a');
        } catch (\RuntimeException $e) {
            $this->assertInstanceOf('\RuntimeException', $e);
        }
        $dip->set('bar', 'a', $barA);
        $this->assertTrue($dip->has('foo', 'a'));
        $this->assertTrue($dip->has('bar', 'a'));
        $this->assertSame($fooA, $dip->get('foo', 'a'));
        $this->assertSame($barA, $dip->get('bar', 'a'));
        $dip->set('foo', 'b', $fooB);
        $this->assertSame($fooB, $dip->get('foo', 'b'));
        $this->assertSame($fooA, $dip->get('foo', 'a'));
    }
}
