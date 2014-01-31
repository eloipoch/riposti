Feature: Riposti Symfony Container Extension
  In order to use Riposti with the Symfony DI Container
  As a Symfony DI Container developer
  I need to import Riposti through a container extension

  Scenario: Load the extension
    Given I have a symfony container
    And I register the container extension "Pablodip\Riposti\Infrastructure\Symfony\DependencyInjection\RipostiExtension"
    When I load the container yaml config:
      """
      riposti:
        class_relations_definition_obtainer_service: foo
        relation_loader_service: bar

      services:
        foo:
          class: Pablodip\Riposti\Infrastructure\Symfony\DependencyInjection\NoClassRelationsDefinitionObtainer
        bar:
          class: Pablodip\Riposti\Infrastructure\Symfony\DependencyInjection\NoRelationLoader
      """
    Then the container should be compilable
    And the container service "riposti.loader" should be gettable
