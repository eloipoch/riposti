<?php

require __DIR__ . '/../../vendor/autoload.php';

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

use Pablodip\Behat\SymfonyContainerContext\SymfonyContainerBehatContext;
use Akamon\Behat\SymfonyKernelContext\SymfonyKernelBehatContext;

class FeatureContext extends BehatContext
{
    public function __construct()
    {
        $this->useContext('symfony_container', new SymfonyContainerBehatContext());
        $this->useContext('symfony_kernel', new SymfonyKernelBehatContext());
    }
}
