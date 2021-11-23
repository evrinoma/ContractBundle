<?php


namespace Evrinoma\ContractBundle\DependencyInjection;

use Evrinoma\ContractBundle\EvrinomaContractBundle;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package Evrinoma\ContractBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
//region SECTION: Getters/Setters
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder      = new TreeBuilder(EvrinomaContractBundle::CONTRACT_BUNDLE);
        $rootNode         = $treeBuilder->getRootNode();
        $supportedDrivers = ['orm'];

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('db_driver')
            ->validate()
            ->ifNotInArray($supportedDrivers)
            ->thenInvalid('The driver %s is not supported. Please choose one of '.json_encode($supportedDrivers))
            ->end()
            ->cannotBeOverwritten()
            ->defaultValue('orm')
            ->end()
            ->scalarNode('factory_side')->cannotBeEmpty()->defaultValue(EvrinomaContractExtension::FACTORY_SIDE)->end()
            ->scalarNode('factory_contract')->cannotBeEmpty()->defaultValue(EvrinomaContractExtension::FACTORY_CONTRACT)->end()
            ->scalarNode('entity_side')->cannotBeEmpty()->defaultValue(EvrinomaContractExtension::ENTITY_BASE_SIDE)->end()
            ->scalarNode('entity_contract')->cannotBeEmpty()->defaultValue(EvrinomaContractExtension::ENTITY_BASE_CONTRACT)->end()
            ->scalarNode('constraints_contract')->defaultTrue()->info('This option is used for enable/disable basic contract constraints')->end()
            ->scalarNode('constraints_side')->defaultTrue()->info('This option is used for enable/disable basic side constraints')->end()
            ->scalarNode('dto_contract')->cannotBeEmpty()->defaultValue(EvrinomaContractExtension::DTO_BASE_CONTRACT)->info('This option is used for dto class override')->end()
            ->scalarNode('dto_side')->cannotBeEmpty()->defaultValue(EvrinomaContractExtension::DTO_BASE_SIDE)->info('This option is used for dto class override')->end()
            ->arrayNode('decorates')->addDefaultsIfNotSet()->children()
            ->scalarNode('command_contract')->defaultNull()->info('This option is used for command contract decoration')->end()
            ->scalarNode('query_contract')->defaultNull()->info('This option is used for query contract decoration')->end()
            ->scalarNode('command_side')->defaultNull()->info('This option is used for command side decoration')->end()
            ->scalarNode('query_side')->defaultNull()->info('This option is used for query side decoration')->end()
            ->end()->end()->end();

        return $treeBuilder;
    }
//endregion Getters/Setters
}
