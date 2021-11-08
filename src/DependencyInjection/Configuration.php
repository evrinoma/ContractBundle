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

        return $treeBuilder;
    }
//endregion Getters/Setters
}
