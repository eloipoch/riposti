<?php

namespace Pablodip\Riposti\Domain\Tests;

use Akamon\MockeryCallableMock\MockeryCallableMock;
use Pablodip\Riposti\Domain\Model\NotLoadedRelation\IdOneTypeNotLoadedRelation;
use Pablodip\Riposti\Domain\RipostiLoaderBuilder;
use Pablodip\Riposti\Domain\Service\ClassRelationsDefinitionObtainer\RelationsDestinationsClassRelationsDefinitionObtainer;
use Pablodip\Riposti\Domain\Service\RelationDataAccessor\PropertyReflectionRelationDataAccessor;
use Pablodip\Riposti\Domain\Tests\Service\RelationDataAccessor\PropertyReflectionRelationDataAccessorTest;
use Pablodip\Riposti\Domain\Tests\Stub\ObjStub1;
use Pablodip\Riposti\Domain\Tests\Stub\ObjStub2;

class RipostiLoaderBuilderTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_build_a_riposti_loader()
    {
        $classRelationsDefinitionObtainer = new MockeryCallableMock();
        $relationDataAccessor = \Mockery::mock('Pablodip\Riposti\Domain\Service\RelationDataAccessor\RelationDataAccessorInterface');
        $relationLoader = \Mockery::mock('Pablodip\Riposti\Domain\Service\RelationLoader\RelationLoaderInterface');

        $builder = new RipostiLoaderBuilder($classRelationsDefinitionObtainer, $relationDataAccessor, $relationLoader);

        $loader = $builder->build();
        $this->assertInstanceOf('Pablodip\Riposti\Domain\RipostiLoader', $loader);
    }

    /** @test */
    public function it_build_a_workable_riposti()
    {
        $destinations = [
            'stub2' => ['loader_info' => 'foo']
        ];
        $relations = [
            'Pablodip\Riposti\Domain\Tests\Stub\ObjStub1' => [
                'a' => [
                    'type' => 'one',
                    'destination' => 'stub2'
                ]
            ]
        ];

        $classRelationsDefinitionObtainer = new RelationsDestinationsClassRelationsDefinitionObtainer($relations, $destinations);
        $relationDataAccessor = new PropertyReflectionRelationDataAccessor();
        $relationLoader = \Mockery::mock('Pablodip\Riposti\Domain\Service\RelationLoader\RelationLoaderInterface');

        $builder = new RipostiLoaderBuilder($classRelationsDefinitionObtainer, $relationDataAccessor, $relationLoader);
        $loader = $builder->build();

        $stub1 = (new ObjStub1())->setA(new IdOneTypeNotLoadedRelation('bar'));
        $stub2 = new ObjStub2();

        $relationLoader->shouldReceive('load')->with('foo', ['bar'])->once()->andReturn(['bar' => $stub2]);

        $loader->load($stub1);
        $this->assertSame($stub2, $stub1->getA());


    }
}
