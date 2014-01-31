<?php

namespace Pablodip\Riposti\Domain\Tests\Service\RelationTypeProcessorObtainer;

use Pablodip\Riposti\Domain\Service\RelationTypeProcessorObtainer\DefaultRelationTypeProcessorObtainer;

class DefaultRelationTypeProcessorObtainerTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_returns_a_processor_by_type()
    {
        $obtainer = new DefaultRelationTypeProcessorObtainer();

        $one = $obtainer('one');
        $this->assertInstanceOf('Pablodip\Riposti\Domain\Service\RelationTypeProcessor\OneRelationTypeProcessor', $one);
    }

    /**
     * @test
     * @expectedException \RuntimeException
     */
    public function it_throws_an_exception_if_the_type_does_not_exist()
    {
        $obtainer = new DefaultRelationTypeProcessorObtainer();

        $obtainer('no');
    }
}
