<?php

namespace Pablodip\Riposti\Domain\Tests;

use Pablodip\Riposti\Domain\Model\NotLoadedRelation\IdOneTypeNotLoadedRelation;
use Pablodip\Riposti\Domain\RipostiLoaderBuilder;
use Pablodip\Riposti\Domain\Service\ClassRelationsMetadataObtainer\ClassRelationsMetadataObtainerInterface;
use Pablodip\Riposti\Domain\Service\ClassRelationsMetadataObtainer\RelationsDestinationsClassRelationsMetadataObtainer;
use Pablodip\Riposti\Domain\Service\RelationDataAccessor\PropertyReflectionRelationDataAccessor;
use Pablodip\Riposti\Domain\Service\RelationDataAccessor\RelationDataAccessorInterface;
use Pablodip\Riposti\Domain\Service\RelationLoader\RelationLoaderInterface;
use Pablodip\Riposti\Domain\Tests\Stub\ObjStub1;
use Pablodip\Riposti\Domain\Tests\Stub\ObjStub2;

class RipostiLoaderBuilderTest extends RipostiTestCase
{
    /** @test */
    public function it_build_a_riposti_loader()
    {
        $classRelationsMetadataObtainer = $this->mock(ClassRelationsMetadataObtainerInterface::class);
        $relationDataAccessor = $this->mock(RelationDataAccessorInterface::class);
        $relationLoader = $this->mock(RelationLoaderInterface::class);

        $builder = new RipostiLoaderBuilder($classRelationsMetadataObtainer, $relationDataAccessor, $relationLoader);

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

        $classRelationsMetadataObtainer = new RelationsDestinationsClassRelationsMetadataObtainer($relations, $destinations);
        $relationDataAccessor = new PropertyReflectionRelationDataAccessor();
        $relationLoader = $this->mock(RelationLoaderInterface::class);

        $builder = new RipostiLoaderBuilder($classRelationsMetadataObtainer, $relationDataAccessor, $relationLoader);
        $loader = $builder->build();

        $stub1 = (new ObjStub1())->setA(new IdOneTypeNotLoadedRelation('bar'));
        $stub2 = new ObjStub2();

        $relationLoader->shouldReceive('load')->with('foo', ['bar'])->once()->andReturn(['bar' => $stub2]);

        $loader->load($stub1);
        $this->assertSame($stub2, $stub1->getA());
    }
}
