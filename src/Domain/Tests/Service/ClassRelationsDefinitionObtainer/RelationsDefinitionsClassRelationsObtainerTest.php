<?php

namespace Pablodip\Riposti\Domain\Tests\Service\ClassRelationsDefinitionObtainer;

use Pablodip\Riposti\Domain\Metadata\ClassRelationsMetadata;
use Pablodip\Riposti\Domain\Metadata\DestinationMetadata;
use Pablodip\Riposti\Domain\Metadata\RelationMetadata;
use Pablodip\Riposti\Domain\Service\ClassRelationsDefinitionObtainer\RelationsDestinationsClassRelationsDefinitionObtainer;

class RelationsDefinitionsClassRelationsObtainerTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_works()
    {
        $destinationsInfo = [
            'author_dest' => [
                'loader_info' => 'foo'
            ]
        ];
        $relationsInfo = [
            'Model\Article' => [
                'author' => [
                    'type' => 'one',
                    'destination' => 'author_dest'
                ]
            ]
        ];

        $obtainer = new RelationsDestinationsClassRelationsDefinitionObtainer($relationsInfo, $destinationsInfo);

        $articleRelationsDef = new ClassRelationsMetadata('Model\Article', [
            new RelationMetadata('author', 'one', new DestinationMetadata('author_dest', 'foo'))
        ]);
        $this->assertEquals($articleRelationsDef, $obtainer('Model\Article'));

        try {
            $obtainer('ClassWithNotDefinition');
            $this->fail();
        } catch (\Exception $e) {
            $this->assertInstanceOf('\RuntimeException', $e);
        }
    }
}
