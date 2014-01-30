<?php

namespace Pablodip\Riposti\Domain\Tests;

use Akamon\MockeryCallableMock\MockeryCallableMock;
use Pablodip\Riposti\Domain\RipostiLoader;

class RipostiLoaderTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function mocking()
    {
        $classRelationsObtainer = new MockeryCallableMock();
        $searcher = new MockeryCallableMock();
        $loader = new MockeryCallableMock();
        $assigner = new MockeryCallableMock();

        $ripostiLoader = new RipostiLoader($classRelationsObtainer, $searcher, $loader, $assigner);

        $objs = [new \stdClass(), new \stdClass()];

        $relationsToLoad = new \ArrayObject();
        $loadedRelations = new \ArrayObject();

        $searcher->should()->with($classRelationsObtainer, $objs)->once()->andReturn($relationsToLoad)->ordered();
        $loader->should()->with($relationsToLoad)->once()->andReturn($loadedRelations)->ordered();
        $assigner->should()->with($classRelationsObtainer, $loadedRelations, $objs)->once()->ordered();

        $ripostiLoader->load($objs);
    }

    /** @test */
    public function it_admits_one_single_obj()
    {
        $classRelationsObtainer = new MockeryCallableMock();
        $searcher = new MockeryCallableMock();
        $loader = new MockeryCallableMock();
        $assigner = new MockeryCallableMock();

        $ripostiLoader = new RipostiLoader($classRelationsObtainer, $searcher, $loader, $assigner);

        $obj = new \stdClass();

        $relationsToLoad = new \ArrayObject();
        $loadedRelations = new \ArrayObject();

        $searcher->should()->with($classRelationsObtainer, [$obj])->once()->andReturn($relationsToLoad)->ordered();
        $loader->should()->with($relationsToLoad)->once()->andReturn($loadedRelations)->ordered();
        $assigner->should()->with($classRelationsObtainer, $loadedRelations, [$obj])->once()->ordered();

        $ripostiLoader->load($obj);
    }

    /** @test */
    public function it_admits_relation_names_to_load()
    {
        $classRelationsObtainer = new MockeryCallableMock();
        $searcher = new MockeryCallableMock();
        $loader = new MockeryCallableMock();
        $assigner = new MockeryCallableMock();

        $ripostiLoader = new RipostiLoader($classRelationsObtainer, $searcher, $loader, $assigner);

        $objs = [new \stdClass(), new \stdClass()];
        $relationNamesToLoad = ['foo'];

        $relationsToLoad = new \ArrayObject();
        $loadedRelations = new \ArrayObject();

        $searcher->should()->with($classRelationsObtainer, $objs)->once()->andReturn($relationsToLoad)->ordered();
        $loader->should()->with($relationsToLoad, $relationNamesToLoad)->once()->andReturn($loadedRelations)->ordered();
        $assigner->should()->with($classRelationsObtainer, $loadedRelations, $objs)->once()->ordered();

        $ripostiLoader->load($objs, $relationNamesToLoad);
    }
}
