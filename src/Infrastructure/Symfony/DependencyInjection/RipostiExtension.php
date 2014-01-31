<?php

namespace Pablodip\Riposti\Infrastructure\Symfony\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class RipostiExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/Resources'));
        $loader->load('riposti_services.xml');

        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $container->setAlias(
            'riposti.class_relations_definition_obtainer',
            $config['class_relations_definition_obtainer_service']
        );
        $container->setAlias(
            'riposti.relation_loader',
            $config['relation_loader_service']
        );
    }
}
