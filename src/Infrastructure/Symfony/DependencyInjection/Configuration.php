<?php

namespace Pablodip\Riposti\Infrastructure\Symfony\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('riposti');

        $rootNode
            ->children()
                ->scalarNode('class_relations_definition_obtainer_service')->isRequired()->end()
                ->scalarNode('relation_loader_service')->isRequired()->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
