<?php

namespace Evrinoma\ContractBundle\DependencyInjection;

use Evrinoma\ContractBundle\EvrinomaContractBundle;
use Evrinoma\UtilsBundle\DependencyInjection\HelperTrait;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;


class EvrinomaContractExtension extends Extension
{
    use HelperTrait;


//region SECTION: Public
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
//endregion Public

//region SECTION: Getters/Setters
    public function getAlias()
    {
        return EvrinomaContractBundle::CONTRACT_BUNDLE;
    }
//endregion Getters/Setters
}