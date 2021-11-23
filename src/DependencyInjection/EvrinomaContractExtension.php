<?php

namespace Evrinoma\ContractBundle\DependencyInjection;

use Evrinoma\ContractBundle\Dto\ContractApiDto;
use Evrinoma\ContractBundle\Dto\SideApiDto;
use Evrinoma\ContractBundle\EvrinomaContractBundle;
use Evrinoma\UtilsBundle\DependencyInjection\HelperTrait;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;


class EvrinomaContractExtension extends Extension
{
    use HelperTrait;

//region SECTION: Fields
    public const ENTITY               = 'Evrinoma\ContractBundle\Entity';
    public const FACTORY_SIDE         = 'Evrinoma\ContractBundle\Factory\SideFactory';
    public const FACTORY_CONTRACT     = 'Evrinoma\ContractBundle\Factory\ContractFactory';
    public const ENTITY_BASE_CONTRACT = self::ENTITY.'\Contract\BaseContract';
    public const ENTITY_BASE_SIDE     = self::ENTITY.'\Side\BaseSide';
    public const DTO_BASE_SIDE        = SideApiDto::class;
    public const DTO_BASE_CONTRACT    = ContractApiDto::class;
//endregion Fields

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