<?php

namespace Pablodip\Riposti\Domain\Tests\Service;

use Akamon\MockeryCallableMock\MockeryCallableMock;
use Pablodip\Riposti\Domain\Metadata\ClassRelationsMetadata;
use Pablodip\Riposti\Domain\Metadata\DestinationMetadata;
use Pablodip\Riposti\Domain\Metadata\RelationMetadata;
use Pablodip\Riposti\Domain\Model\NotLoadedRelation\IdOneTypeNotLoadedRelation;
use Pablodip\Riposti\Domain\Model\Relation\RelationToLoad;
use Pablodip\Riposti\Domain\Service\RelationDataAccessor\PropertyReflectionRelationDataAccessor;
use Pablodip\Riposti\Domain\Service\RelationsToLoadSearcher;
use Pablodip\Riposti\Domain\Tests\Stub\ObjStub1;
use Pablodip\Riposti\Domain\Tests\Stub\ObjStub2;

class RelationsToLoadSearcherTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_searches_one_class_with_one_relation()
    {
        $destinyDef = new DestinationMetadata('_', '_');
        $aRelationDef = new RelationMetadata('a', '_', $destinyDef);

        $stub1RelationsDef = new ClassRelationsMetadata('Pablodip\Riposti\Domain\Tests\Stub\ObjStub1', [$aRelationDef]);
        $classRelationsObtainer = new MockeryCallableMock();
        $classRelationsObtainer->should()->with('Pablodip\Riposti\Domain\Tests\Stub\ObjStub1')->andReturn($stub1RelationsDef);

        $searcher = new RelationsToLoadSearcher(new PropertyReflectionRelationDataAccessor());

        $stub1 = (new ObjStub1())->setA(new IdOneTypeNotLoadedRelation('b'));
        $objs = [$stub1];
        $result = $searcher($classRelationsObtainer, $objs);

        $expected = [new RelationToLoad($aRelationDef, $stub1->getA())];

        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function it_does_not_search_for_not_instances_of_not_loaded_relation()
    {
        $destinyDef = new DestinationMetadata('_', '_');
        $aRelationDef = new RelationMetadata('a', '_', $destinyDef);

        $stub1RelationsDef = new ClassRelationsMetadata('Pablodip\Riposti\Domain\Tests\Stub\ObjStub1', [$aRelationDef]);
        $classRelationsObtainer = new MockeryCallableMock();
        $classRelationsObtainer->should()->with('Pablodip\Riposti\Domain\Tests\Stub\ObjStub1')->andReturn($stub1RelationsDef);

        $searcher = new RelationsToLoadSearcher(new PropertyReflectionRelationDataAccessor());

        $stub1 = (new ObjStub1())->setA('b');
        $objs = [$stub1];
        $result = $searcher($classRelationsObtainer, $objs);

        $expected = [];

        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function it_searches_one_class_with_several_relations()
    {
        $destinyDef = new DestinationMetadata('no', 'no');
        $aRelationDef = new RelationMetadata('a', 'one', $destinyDef);
        $cRelationDef = new RelationMetadata('c', 'one', $destinyDef);

        $stub1RelationsDef = new ClassRelationsMetadata('Pablodip\Riposti\Domain\Tests\Stub\ObjStub1', [$aRelationDef, $cRelationDef]);
        $classRelationsObtainer = new MockeryCallableMock();
        $classRelationsObtainer->should()->with('Pablodip\Riposti\Domain\Tests\Stub\ObjStub1')->andReturn($stub1RelationsDef);

        $searcher = new RelationsToLoadSearcher(new PropertyReflectionRelationDataAccessor());

        $stub1 = (new ObjStub1())->setA(new IdOneTypeNotLoadedRelation('b'))->setC(new IdOneTypeNotLoadedRelation('d'));
        $objs = [$stub1];
        $result = $searcher($classRelationsObtainer, $objs);

        $expected = [
            new RelationToLoad($aRelationDef, $stub1->getA()),
            new RelationToLoad($cRelationDef, $stub1->getC()),
        ];

        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function it_searches_several_classes_with_one_relation()
    {
        $destinyDef = new DestinationMetadata('no', 'no');
        $aRelationDef = new RelationMetadata('a', 'one', $destinyDef);
        $eRelationDef = new RelationMetadata('e', 'one', $destinyDef);

        $stub1RelationsDef = new ClassRelationsMetadata('Pablodip\Riposti\Domain\Tests\Stub\ObjStub1', [$aRelationDef]);
        $stub2RelationsDef = new ClassRelationsMetadata('Pablodip\Riposti\Domain\Tests\Stub\ObjStub2', [$eRelationDef]);
        $classRelationsObtainer = new MockeryCallableMock();
        $classRelationsObtainer->should()->with('Pablodip\Riposti\Domain\Tests\Stub\ObjStub1')->andReturn($stub1RelationsDef);
        $classRelationsObtainer->should()->with('Pablodip\Riposti\Domain\Tests\Stub\ObjStub2')->andReturn($stub2RelationsDef);

        $searcher = new RelationsToLoadSearcher(new PropertyReflectionRelationDataAccessor());

        $objs = [
            $stub1 = (new ObjStub1())->setA(new IdOneTypeNotLoadedRelation('b')),
            $stub2 = (new ObjStub2())->setE(new IdOneTypeNotLoadedRelation('f'))
        ];
        $result = $searcher($classRelationsObtainer, $objs);

        $expected = [
            new RelationToLoad($aRelationDef, $stub1->getA()),
            new RelationToLoad($eRelationDef, $stub2->getE()),
        ];

        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function it_searches_several_classes_with_several_relation()
    {
        $destinyDef = new DestinationMetadata('no', 'no');

        $aRelationDef = new RelationMetadata('a', 'one', $destinyDef);
        $cRelationDef = new RelationMetadata('c', 'one', $destinyDef);
        $eRelationDef = new RelationMetadata('e', 'one', $destinyDef);
        $gRelationDef = new RelationMetadata('g', 'one', $destinyDef);

        $stub1RelationsDef = new ClassRelationsMetadata('Pablodip\Riposti\Domain\Tests\Stub\ObjStub1', [$aRelationDef, $cRelationDef]);
        $stub2RelationsDef = new ClassRelationsMetadata('Pablodip\Riposti\Domain\Tests\Stub\ObjStub2', [$eRelationDef, $gRelationDef]);
        $classRelationsObtainer = new MockeryCallableMock();
        $classRelationsObtainer->should()->with('Pablodip\Riposti\Domain\Tests\Stub\ObjStub1')->andReturn($stub1RelationsDef);
        $classRelationsObtainer->should()->with('Pablodip\Riposti\Domain\Tests\Stub\ObjStub2')->andReturn($stub2RelationsDef);

        $searcher = new RelationsToLoadSearcher(new PropertyReflectionRelationDataAccessor());

        $objs = [
            $stub1 = (new ObjStub1())->setA(new IdOneTypeNotLoadedRelation('b'))->setC(new IdOneTypeNotLoadedRelation('d')),
            $stub2 = (new ObjStub2())->setE(new IdOneTypeNotLoadedRelation('f'))->setG(new IdOneTypeNotLoadedRelation('h'))
        ];
        $result = $searcher($classRelationsObtainer, $objs);

        $expected = [
            new RelationToLoad($aRelationDef, $stub1->getA()),
            new RelationToLoad($cRelationDef, $stub1->getC()),
            new RelationToLoad($eRelationDef, $stub2->getE()),
            new RelationToLoad($gRelationDef, $stub2->getG()),
        ];

        $this->assertEquals($expected, $result);
    }
}
