Feature: PablodipRipostiBundle
  In order to load relations through Riposti with Symfony
  As a developer
  I want to use the PablodipRipostiBundle

  Scenario: Booting the kernel
    Given I have a symfony kernel
    And I use the bundle "Pablodip\Riposti\Infrastructure\Symfony\Bundle\PablodipRipostiBundle"
    And I have the kernel yaml config:
      """
      riposti:
        class_relations_definition_obtainer_service: foo
        relation_loader_service: bar

      services:
        foo:
          class: Pablodip\Riposti\Infrastructure\Symfony\DependencyInjection\NoClassRelationsMetadataObtainer
        bar:
          class: Pablodip\Riposti\Infrastructure\Symfony\DependencyInjection\NoRelationLoader
      """
    When I boot the symfony kernel
    Then the symfony kernel should be booted
#    And the symfony kernel container service "riposti.loader" should be gettable
