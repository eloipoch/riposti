<?php

namespace Pablodip\Riposti\Domain\Tests\Service\RelationDataAccessor;

use Pablodip\Riposti\Domain\Service\RelationDataAccessor\PropertyReflectionRelationDataAccessor;
use Pablodip\Riposti\Domain\Tests\Stub\ObjStub1;

class PropertyReflectionRelationDataAccessorTest extends \PHPUnit_Framework_TestCase
{
    /** @var PropertyReflectionRelationDataAccessor */
    private $accessor;

    protected function setUp()
    {
        $this->accessor = new PropertyReflectionRelationDataAccessor();
    }

    /** @test */
    public function get_returns_data_accessing_through_property_reflection()
    {
        $obj = new ObjStub1();
        $obj->setA('b');
        $obj->setC('d');

        $this->assertSame('b', $this->accessor->get($obj, 'a'));
        $this->assertSame('d', $this->accessor->get($obj, 'c'));
    }

    /** @test */
    public function set_sets_data_accessing_through_property_reflection()
    {
        $obj = new ObjStub1();

        $this->accessor->set($obj, 'a', 'b');
        $this->assertSame('b', $obj->getA());

        $this->accessor->set($obj, 'c', 'd');
        $this->assertSame('d', $obj->getC());
    }
}
