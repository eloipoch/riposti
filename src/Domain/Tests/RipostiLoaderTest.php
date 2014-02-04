<?php

namespace Pablodip\Riposti\Domain\Tests;

use Pablodip\Riposti\Domain\RipostiLoader;
use Pablodip\Riposti\Domain\Service\ClassRelationsAssigner\ClassRelationsAssignerInterface;
use Pablodip\Riposti\Domain\Service\ClassRelationsMetadataObtainer\ClassRelationsMetadataObtainerInterface;
use Pablodip\Riposti\Domain\Service\RelationsToLoadLoader\RelationsToLoadLoaderInterface;
use Pablodip\Riposti\Domain\Service\RelationsToLoadSearcher\RelationsToLoadSearcherInterface;

class RipostiLoaderTest extends RipostiTestCase
{
    /** @test */
    public function mocking()
    {
        $classRelationsMetadataObtainer = $this->mock(ClassRelationsMetadataObtainerInterface::class);
        $searcher = $this->mock(RelationsToLoadSearcherInterface::class);
        $loader = $this->mock(RelationsToLoadLoaderInterface::class);
        $assigner = $this->mock(ClassRelationsAssignerInterface::class);

        $ripostiLoader = new RipostiLoader($classRelationsMetadataObtainer, $searcher, $loader, $assigner);

        $objs = [new \stdClass(), new \stdClass()];

        $relationsToLoad = new \ArrayObject();
        $loadedRelations = new \ArrayObject();

        $searcher->shouldReceive('__invoke')->with($classRelationsMetadataObtainer, $objs)->once()->andReturn($relationsToLoad)->ordered();
        $loader->shouldReceive('__invoke')->with($relationsToLoad)->once()->andReturn($loadedRelations)->ordered();
        $assigner->shouldReceive('__invoke')->with($classRelationsMetadataObtainer, $loadedRelations, $objs)->once()->ordered();

        $ripostiLoader->load($objs);
    }

    /** @test */
    public function it_admits_one_single_obj()
    {
        $classRelationsMetadataObtainer = $this->mock(ClassRelationsMetadataObtainerInterface::class);
        $searcher = $this->mock(RelationsToLoadSearcherInterface::class);
        $loader = $this->mock(RelationsToLoadLoaderInterface::class);
        $assigner = $this->mock(ClassRelationsAssignerInterface::class);

        $ripostiLoader = new RipostiLoader($classRelationsMetadataObtainer, $searcher, $loader, $assigner);

        $obj = new \stdClass();

        $relationsToLoad = new \ArrayObject();
        $loadedRelations = new \ArrayObject();

        $searcher->shouldReceive('__invoke')->with($classRelationsMetadataObtainer, [$obj])->once()->andReturn($relationsToLoad)->ordered();
        $loader->shouldReceive('__invoke')->with($relationsToLoad)->once()->andReturn($loadedRelations)->ordered();
        $assigner->shouldReceive('__invoke')->with($classRelationsMetadataObtainer, $loadedRelations, [$obj])->once()->ordered();

        $ripostiLoader->load($obj);
    }

    /** @test */
    public function it_admits_relation_names_to_load()
    {
        $classRelationsMetadataObtainer = $this->mock(ClassRelationsMetadataObtainerInterface::class);
        $searcher = $this->mock(RelationsToLoadSearcherInterface::class);
        $loader = $this->mock(RelationsToLoadLoaderInterface::class);
        $assigner = $this->mock(ClassRelationsAssignerInterface::class);

        $ripostiLoader = new RipostiLoader($classRelationsMetadataObtainer, $searcher, $loader, $assigner);

        $objs = [new \stdClass(), new \stdClass()];
        $relationNamesToLoad = ['foo'];

        $relationsToLoad = new \ArrayObject();
        $loadedRelations = new \ArrayObject();

        $searcher->shouldReceive('__invoke')->with($classRelationsMetadataObtainer, $objs)->once()->andReturn($relationsToLoad)->ordered();
        $loader->shouldReceive('__invoke')->with($relationsToLoad, $relationNamesToLoad)->once()->andReturn($loadedRelations)->ordered();
        $assigner->shouldReceive('__invoke')->with($classRelationsMetadataObtainer, $loadedRelations, $objs)->once()->ordered();

        $ripostiLoader->load($objs, $relationNamesToLoad);
    }
}
