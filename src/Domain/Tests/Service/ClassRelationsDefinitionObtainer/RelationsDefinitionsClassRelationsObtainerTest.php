<?php

namespace Pablodip\Riposti\Domain\Tests\Service\ClassRelationsDefinitionObtainer;

use Pablodip\Riposti\Domain\Model\ClassRelations\ClassRelationsDefinition;
use Pablodip\Riposti\Domain\Model\Destination\DestinationDefinition;
use Pablodip\Riposti\Domain\Model\Relation\RelationDefinition;
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

        $articleRelationsDef = new ClassRelationsDefinition('Model\Article', [
            new RelationDefinition('author', 'one', new DestinationDefinition('author_dest', 'foo'))
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
