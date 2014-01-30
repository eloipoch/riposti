<?php

namespace Pablodip\Riposti\Domain\Tests\Service;

use Akamon\MockeryCallableMock\MockeryCallableMock;
use Pablodip\Riposti\Domain\Model\Destination\DestinationDefinition;
use Pablodip\Riposti\Domain\Model\NotLoadedRelation\IdOneTypeNotLoadedRelation;
use Pablodip\Riposti\Domain\Model\Relation\RelationDefinition;
use Pablodip\Riposti\Domain\Model\Relation\RelationLoaded;
use Pablodip\Riposti\Domain\Model\Relation\RelationToLoad;
use Pablodip\Riposti\Domain\Service\DestinationIdentityMap\DestinationIdentityMap;
use Pablodip\Riposti\Domain\Service\RelationLoader\CallableRelationLoader;
use Pablodip\Riposti\Domain\Service\RelationsToLoadLoader;
use Pablodip\Riposti\Domain\Service\RelationTypeProcessor\OneRelationTypeProcessor;

class RelationsToLoadLoaderTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_loads_one_type_one_relation_from_loader()
    {
        $id = 'ups';
        $data = new \stdClass();
        $notLoadedRelation = new IdOneTypeNotLoadedRelation($id);

        $relationTypeProcessorObtainer = new MockeryCallableMock();
        $destinationIdentityMap = new DestinationIdentityMap();
        $relationLoader = new CallableRelationLoader();
        $loader = new RelationsToLoadLoader($relationTypeProcessorObtainer, $destinationIdentityMap, $relationLoader);

        $oneRelationTypeProcessor = new OneRelationTypeProcessor();
        $relationTypeProcessorObtainer->should()->with('one')->andReturn($oneRelationTypeProcessor);

        $loaderInfo = new MockeryCallableMock();

        $destinationDef = new DestinationDefinition('foo', $loaderInfo);
        $relationDef = new RelationDefinition('bar', 'one', $destinationDef);

        $relationsToLoad = [
            new RelationToLoad($relationDef, $notLoadedRelation)
        ];

        $loaderInfo->should()->with([$id])->once()->andReturn([$id => $data]);

        $result = $loader($relationsToLoad);
        $expected = [
            new RelationLoaded($relationsToLoad[0], $data)
        ];

        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function it_loads_one_type_several_relations_different_destinations_from_loader()
    {
        $id1 = 'ups';
        $id2 = 'yep';
        $data1 = new \stdClass();
        $data2 = new \ArrayObject();
        $notLoadedRelation1 = new IdOneTypeNotLoadedRelation($id1);
        $notLoadedRelation2 = new IdOneTypeNotLoadedRelation($id2);

        $relationTypeProcessorObtainer = new MockeryCallableMock();
        $destinationIdentityMap = new DestinationIdentityMap();
        $relationLoader = new CallableRelationLoader();
        $loader = new RelationsToLoadLoader($relationTypeProcessorObtainer, $destinationIdentityMap, $relationLoader);

        $oneRelationTypeProcessor = new OneRelationTypeProcessor();
        $relationTypeProcessorObtainer->should()->with('one')->andReturn($oneRelationTypeProcessor);

        $loaderInfo1 = new MockeryCallableMock();
        $loaderInfo2 = new MockeryCallableMock();

        $destinationDef1 = new DestinationDefinition('foo1', $loaderInfo1);
        $destinationDef2 = new DestinationDefinition('foo2', $loaderInfo2);
        $relationDef1 = new RelationDefinition('bar', 'one', $destinationDef1);
        $relationDef2 = new RelationDefinition('bar', 'one', $destinationDef2);

        $relationsToLoad = [
            new RelationToLoad($relationDef1, $notLoadedRelation1),
            new RelationToLoad($relationDef2, $notLoadedRelation2)
        ];

        $loaderInfo1->should()->with([$id1])->once()->andReturn([$id1 => $data1])->ordered();
        $loaderInfo2->should()->with([$id2])->once()->andReturn([$id2 => $data2])->ordered();

        $result = $loader($relationsToLoad);
        $expected = [
            new RelationLoaded($relationsToLoad[0], $data1),
            new RelationLoaded($relationsToLoad[1], $data2)
        ];

        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function it_loads_one_type_several_relations_same_destinations_from_loader()
    {
        $id1 = 'ups';
        $id2 = 'yep';
        $data1 = new \stdClass();
        $data2 = new \ArrayObject();

        $relationTypeProcessorObtainer = new MockeryCallableMock();
        $destinationIdentityMap = new DestinationIdentityMap();
        $relationLoader = new CallableRelationLoader();
        $loader = new RelationsToLoadLoader($relationTypeProcessorObtainer, $destinationIdentityMap, $relationLoader);

        $oneRelationTypeProcessor = new OneRelationTypeProcessor();
        $relationTypeProcessorObtainer->should()->with('one')->andReturn($oneRelationTypeProcessor);

        $loaderInfo = new MockeryCallableMock();

        $destinationDef = new DestinationDefinition('foo', $loaderInfo);
        $relationDef1 = new RelationDefinition('bar', 'one', $destinationDef);
        $relationDef2 = new RelationDefinition('bar', 'one', $destinationDef);

        $relationsToLoad = [
            new RelationToLoad($relationDef1, new IdOneTypeNotLoadedRelation($id1)),
            new RelationToLoad($relationDef2, new IdOneTypeNotLoadedRelation($id2))
        ];

        $loaderInfo->should()->with([$id1, $id2])->once()->andReturn([$id1 => $data1, $id2 => $data2]);

        $result = $loader($relationsToLoad);
        $expected = [
            new RelationLoaded($relationsToLoad[0], $data1),
            new RelationLoaded($relationsToLoad[1], $data2)
        ];

        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function it_loads_one_type_one_relation_from_the_destination_identity_map()
    {
        $id = 'ups';
        $data = new \stdClass();

        $destinationIdentityMap = new DestinationIdentityMap();
        $destinationIdentityMap->set('foo', $id, $data);

        $relationTypeProcessorObtainer = new MockeryCallableMock();
        $relationLoader = new CallableRelationLoader();
        $loader = new RelationsToLoadLoader($relationTypeProcessorObtainer, $destinationIdentityMap, $relationLoader);

        $oneRelationTypeProcessor = new OneRelationTypeProcessor();
        $relationTypeProcessorObtainer->should()->with('one')->andReturn($oneRelationTypeProcessor);

        $loaderInfo = new MockeryCallableMock();

        $destinationDef = new DestinationDefinition('foo', $loaderInfo);
        $relationDef = new RelationDefinition('bar', 'one', $destinationDef);

        $relationsToLoad = [
            new RelationToLoad($relationDef, new IdOneTypeNotLoadedRelation($id))
        ];

        $result = $loader($relationsToLoad);
        $expected = [
            new RelationLoaded($relationsToLoad[0], $data)
        ];

        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function it_loads_one_type_several_relations_from_the_destination_identity_map()
    {
        $id1 = 'ups';
        $id2 = 'yep';
        $data1 = new \stdClass();
        $data2 = new \ArrayObject();

        $destinationIdentityMap = new DestinationIdentityMap();
        $destinationIdentityMap->set('foo1', $id1, $data1);
        $destinationIdentityMap->set('foo2', $id2, $data2);

        $relationTypeProcessorObtainer = new MockeryCallableMock();
        $relationLoader = new CallableRelationLoader();
        $loader = new RelationsToLoadLoader($relationTypeProcessorObtainer, $destinationIdentityMap, $relationLoader);

        $oneRelationTypeProcessor = new OneRelationTypeProcessor();
        $relationTypeProcessorObtainer->should()->with('one')->andReturn($oneRelationTypeProcessor);

        $loaderInfo1 = new MockeryCallableMock();
        $loaderInfo2 = new MockeryCallableMock();

        $destinationDef1 = new DestinationDefinition('foo1', $loaderInfo1);
        $destinationDef2 = new DestinationDefinition('foo2', $loaderInfo2);
        $relationDef1 = new RelationDefinition('bar', 'one', $destinationDef1);
        $relationDef2 = new RelationDefinition('bar', 'one', $destinationDef2);

        $relationsToLoad = [
            new RelationToLoad($relationDef1, new IdOneTypeNotLoadedRelation($id1)),
            new RelationToLoad($relationDef2, new IdOneTypeNotLoadedRelation($id2))
        ];

        $result = $loader($relationsToLoad);
        $expected = [
            new RelationLoaded($relationsToLoad[0], $data1),
            new RelationLoaded($relationsToLoad[1], $data2)
        ];

        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function it_loads_only_indicated_relations_from_loader()
    {
        $id1 = 'ups';
        $id2 = 'yep';
        $data1 = new \stdClass();
        $data2 = new \ArrayObject();

        $relationTypeProcessorObtainer = new MockeryCallableMock();
        $destinationIdentityMap = new DestinationIdentityMap();
        $relationLoader = new CallableRelationLoader();
        $loader = new RelationsToLoadLoader($relationTypeProcessorObtainer, $destinationIdentityMap, $relationLoader);

        $oneRelationTypeProcessor = new OneRelationTypeProcessor();
        $relationTypeProcessorObtainer->should()->with('one')->andReturn($oneRelationTypeProcessor);

        $loaderInfo1 = new MockeryCallableMock();
        $loaderInfo2 = new MockeryCallableMock();

        $destinationDef1 = new DestinationDefinition('_', $loaderInfo1);
        $destinationDef2 = new DestinationDefinition('_', $loaderInfo2);
        $relationDef1 = new RelationDefinition('foo1', 'one', $destinationDef1);
        $relationDef2 = new RelationDefinition('foo2', 'one', $destinationDef2);

        $relationsToLoad = [
            new RelationToLoad($relationDef1, new IdOneTypeNotLoadedRelation($id1)),
            new RelationToLoad($relationDef2, new IdOneTypeNotLoadedRelation($id2))
        ];

        $loaderInfo2->should()->with([$id2])->once()->andReturn([$id2 => $data2]);

        $result = $loader($relationsToLoad, ['foo2']);
        $expected = [
            new RelationLoaded($relationsToLoad[1], $data2)
        ];

        $this->assertEquals($expected, $result);
    }
}
