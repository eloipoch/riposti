<?php

namespace Pablodip\Riposti\Domain\Tests\Stub;

class ObjStub3 extends ObjStub1
{
    private $y;

    public function setY($y)
    {
        $this->y = $y;

        return $this;
    }

    public function getY()
    {
        return $this->y;
    }
}
