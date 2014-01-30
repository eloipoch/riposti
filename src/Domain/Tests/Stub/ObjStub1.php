<?php

namespace Pablodip\Riposti\Domain\Tests\Stub;

class ObjStub1
{
    private $a;
    private $c;

    public function setA($a)
    {
        $this->a = $a;

        return $this;
    }

    public function getA()
    {
        return $this->a;
    }

    public function setC($c)
    {
        $this->c = $c;

        return $this;
    }

    public function getC()
    {
        return $this->c;
    }
}
