<?php

namespace Pablodip\Riposti\Domain\Tests;

class RipostiTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @return \Mockery\MockInterface
     */
    public function mock($class)
    {
        return \Mockery::mock($class);
    }
}
