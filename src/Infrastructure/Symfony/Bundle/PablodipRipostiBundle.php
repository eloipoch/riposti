<?php

namespace Pablodip\Riposti\Infrastructure\Symfony\Bundle;

use Pablodip\Riposti\Infrastructure\Symfony\DependencyInjection\RipostiExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class PablodipRipostiBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new RipostiExtension();
    }
}
