<?php

namespace Pablodip\Riposti\Domain\Tests\Service;

use Akamon\MockeryCallableMock\MockeryCallableMock;
use Pablodip\Riposti\Domain\Metadata\ClassRelationsMetadata;
use Pablodip\Riposti\Domain\Metadata\DestinationMetadata;
use Pablodip\Riposti\Domain\Metadata\RelationMetadata;
use Pablodip\Riposti\Domain\Model\NotLoadedRelation\IdOneTypeNotLoadedRelation;
use Pablodip\Riposti\Domain\Model\Relation\LoadedRelation;
use Pablodip\Riposti\Domain\Model\Relation\RelationToLoad;
use Pablodip\Riposti\Domain\Service\ClassRelationsAssigner;
use Pablodip\Riposti\Domain\Service\RelationDataAccessor\PropertyReflectionRelationDataAccessor;
use Pablodip\Riposti\Domain\Tests\Stub\ObjStub1;

class ClassRelationsAssignerTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_assignes_one_loaded_relation()
    {
        $relationDataAccessor = new PropertyReflectionRelationDataAccessor();
        $assigner = new ClassRelationsAssigner($relationDataAccessor);

        $id = 'foo';
        $data = new \stdClass();

        $destinationDef = new DestinationMetadata('_', '_');
        $aRelationDef = new RelationMetadata('a', '_', $destinationDef);
        $relationToLoad = new RelationToLoad($aRelationDef, new IdOneTypeNotLoadedRelation($id));

        $stub1RelationsDef = new ClassRelationsMetadata('Pablodip\Riposti\Domain\Tests\Stub\ObjStub1', [$aRelationDef]);
        $classRelationsObtainer = new MockeryCallableMock();
        $classRelationsObtainer->should()->with('Pablodip\Riposti\Domain\Tests\Stub\ObjStub1')->andReturn($stub1RelationsDef);

        $loadedRelations = [
            new LoadedRelation($relationToLoad, $data)
        ];

        $objs = [
            $stub1 = (new ObjStub1())->setA(new IdOneTypeNotLoadedRelation($id))
        ];

        $assigner($classRelationsObtainer, $loadedRelations, $objs);

        $this->assertSame($data, $stub1->getA());
        $this->assertNull($stub1->getC());
    }

    /** @test */
    public function it_assignes_several_loaded_relation()
    {
        $relationDataAccessor = new PropertyReflectionRelationDataAccessor();
        $assigner = new ClassRelationsAssigner($relationDataAccessor);

        $id1 = 'foo';
        $data1 = new \stdClass();
        $id2 = 'bar';
        $data2 = new \stdClass();

        $destinationDef = new DestinationMetadata('_', '_');
        $aRelationDef = new RelationMetadata('a', '_', $destinationDef);
        $cRelationDef = new RelationMetadata('c', '_', $destinationDef);

        $stub1RelationsDef = new ClassRelationsMetadata('Pablodip\Riposti\Domain\Tests\Stub\ObjStub1', [$aRelationDef, $cRelationDef]);
        $classRelationsObtainer = new MockeryCallableMock();
        $classRelationsObtainer->should()->with('Pablodip\Riposti\Domain\Tests\Stub\ObjStub1')->andReturn($stub1RelationsDef);

        $loadedRelations = [
            new LoadedRelation(new RelationToLoad($aRelationDef, new IdOneTypeNotLoadedRelation($id1)), $data1),
            new LoadedRelation(new RelationToLoad($cRelationDef, new IdOneTypeNotLoadedRelation($id2)), $data2),
        ];

        $objs = [
            $stub11 = (new ObjStub1())->setA(new IdOneTypeNotLoadedRelation($id1)),
            $stub12 = (new ObjStub1())->setC(new IdOneTypeNotLoadedRelation($id2))
        ];

        $assigner($classRelationsObtainer, $loadedRelations, $objs);

        $this->assertSame($data1, $stub11->getA());
        $this->assertNull($stub11->getC());
        $this->assertSame($data2, $stub12->getC());
        $this->assertNull($stub12->getA());
    }

    /** @test */
    public function it_assignes_relations_only_when_needed()
    {
        $relationDataAccessor = new PropertyReflectionRelationDataAccessor();
        $assigner = new ClassRelationsAssigner($relationDataAccessor);

        $id = 'foo';
        $data = new \stdClass();

        $destinationDef = new DestinationMetadata('_', '_');
        $aRelationDef = new RelationMetadata('a', '_', $destinationDef);
        $relationToLoad = new RelationToLoad($aRelationDef, new IdOneTypeNotLoadedRelation($id));

        $stub1RelationsDef = new ClassRelationsMetadata('Pablodip\Riposti\Domain\Tests\Stub\ObjStub1', [$aRelationDef]);
        $classRelationsObtainer = new MockeryCallableMock();
        $classRelationsObtainer->should()->with('Pablodip\Riposti\Domain\Tests\Stub\ObjStub1')->andReturn($stub1RelationsDef);

        $loadedRelations = [
            new LoadedRelation($relationToLoad, $data)
        ];

        $objs = [
            $stub11 = (new ObjStub1())->setA(new IdOneTypeNotLoadedRelation($id)),
            $stub12 = (new ObjStub1())->setA('b')
        ];

        $assigner($classRelationsObtainer, $loadedRelations, $objs);

        $this->assertSame($data, $stub11->getA());
        $this->assertNull($stub11->getC());
        $this->assertSame('b', $stub12->getA());
    }
}
