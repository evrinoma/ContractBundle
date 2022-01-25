<?php

namespace Evrinoma\ContractBundle\DependencyInjection;

use Evrinoma\ContractBundle\DependencyInjection\Compiler\Constraint\Complex\SidePass;
use Evrinoma\ContractBundle\DependencyInjection\Compiler\Constraint\Property\ContractPass as PropertyContractPass;
use Evrinoma\ContractBundle\DependencyInjection\Compiler\Constraint\Property\HierarchyPass as PropertyHierarchyPass;
use Evrinoma\ContractBundle\DependencyInjection\Compiler\Constraint\Property\SidePass as PropertySidePass;
use Evrinoma\ContractBundle\DependencyInjection\Compiler\Constraint\Property\TypePass as PropertyTypePass;
use Evrinoma\ContractBundle\Dto\ContractApiDto;
use Evrinoma\ContractBundle\Dto\SideApiDto;
use Evrinoma\ContractBundle\Entity\Define\BaseHierarchy;
use Evrinoma\ContractBundle\Entity\Define\BaseType;
use Evrinoma\ContractBundle\EvrinomaContractBundle;
use Evrinoma\UtilsBundle\DependencyInjection\HelperTrait;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Validator\Validator\TraceableValidator;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class EvrinomaContractExtension extends Extension //implements PrependExtensionInterface
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
    /**
     * @var array
     */
    private static array $doctrineDrivers = array(
        'orm' => array(
            'registry' => 'doctrine',
            'tag'      => 'doctrine.event_subscriber',
        ),
    );
//endregion Fields

//region SECTION: Public
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        if ($container->getParameter('kernel.environment') !== 'prod') {
            $loader->load('fixtures.yml');
        }

        if ($container->getParameter('kernel.environment') === 'test') {
            $loader->load('tests.yml');
        }

        $configuration = $this->getConfiguration($configs, $container);
        $config        = $this->processConfiguration($configuration, $configs);

        if ($config['factory_side'] !== self::FACTORY_SIDE) {
            $this->wireFactory($container, 'side', $config['factory_side'], $config['entity_side']);
        } else {
            $definitionFactory = $container->getDefinition('evrinoma.'.$this->getAlias().'.side.factory');
            $definitionFactory->setArgument(0, $config['entity_side']);
        }

        if ($config['factory_contract'] !== self::FACTORY_CONTRACT) {
            $this->wireFactory($container, 'contract', $config['factory_contract'], $config['entity_contract']);
        } else {
            $definitionFactory = $container->getDefinition('evrinoma.'.$this->getAlias().'.contract.factory');
            $definitionFactory->setArgument(0, $config['entity_contract']);
        }

        $doctrineRegistry = null;

        if (isset(self::$doctrineDrivers[$config['db_driver']])) {
            $loader->load('doctrine.yml');
            $container->setAlias('evrinoma.'.$this->getAlias().'.doctrine_registry', new Alias(self::$doctrineDrivers[$config['db_driver']]['registry'], false));
            $doctrineRegistry = new Reference('evrinoma.'.$this->getAlias().'.doctrine_registry');
            $container->setParameter('evrinoma.'.$this->getAlias().'.backend_type_'.$config['db_driver'], true);
            $objectManager = $container->getDefinition('evrinoma.'.$this->getAlias().'.object_manager');
            $objectManager->setFactory([$doctrineRegistry, 'getManager']);
        }

        $this->remapParametersNamespaces(
            $container,
            $config,
            [
                '' => [
                    'db_driver'       => 'evrinoma.'.$this->getAlias().'.storage',
                    'entity_side'     => 'evrinoma.'.$this->getAlias().'.entity_side',
                    'entity_contract' => 'evrinoma.'.$this->getAlias().'.entity_contract',
                ],
            ]
        );

        if ($doctrineRegistry) {
            $this->wireRepository($container, $doctrineRegistry, 'type', BaseType::class);
            $this->wireRepository($container, $doctrineRegistry, 'hierarchy', BaseHierarchy::class);
            $this->wireRepository($container, $doctrineRegistry, 'contract', $config['entity_contract']);
            $this->wireRepository($container, $doctrineRegistry, 'side', $config['entity_side']);
        }

        $this->wireController($container, 'contract', $config['dto_contract']);
        $this->wireController($container, 'side', $config['dto_side']);

        $this->wireValidator($container, 'contract', $config['entity_contract']);
        $this->wireValidator($container, 'side', $config['entity_side']);

        $loader->load('validation.yml');

        if ($config['constraints_side']) {
            $loader->load('constraint/side.yml');
        }

        if ($config['constraints_contract']) {
            $loader->load('constraint/contract.yml');
        }

        $this->wireConstraintTag($container);

        if ($config['decorates']) {
            $this->remapParametersNamespaces(
                $container,
                $config['decorates'],
                [
                    '' => [
                        'command_side'     => 'evrinoma.'.$this->getAlias().'.decorates.side.command',
                        'query_side'       => 'evrinoma.'.$this->getAlias().'.decorates.side.query',
                        'command_contract' => 'evrinoma.'.$this->getAlias().'.decorates.contract.command',
                        'query_contract'   => 'evrinoma.'.$this->getAlias().'.decorates.contract.query',
                    ],
                ]
            );
        }
    }
//endregion Public

//region SECTION: Private
    private function wireConstraintTag(ContainerBuilder $container): void
    {
        foreach ($container->getDefinitions() as $key => $definition) {
            switch (true) {
                case strpos($key, PropertyTypePass::CONTRACT_TYPE_CONSTRAINT) !== false :
                    $definition->addTag(PropertyTypePass::CONTRACT_TYPE_CONSTRAINT);
                    break;
                case strpos($key, PropertyHierarchyPass::CONTRACT_HIERARCHY_CONSTRAINT) !== false :
                    $definition->addTag(PropertyHierarchyPass::CONTRACT_HIERARCHY_CONSTRAINT);
                    break;
                case strpos($key, SidePass::CONTRACT_SIDE_CONSTRAINT) !== false :
                    $definition->addTag(SidePass::CONTRACT_SIDE_CONSTRAINT);
                    break;
                case strpos($key, PropertySidePass::CONTRACT_SIDE_CONSTRAINT) !== false :
                    $definition->addTag(PropertySidePass::CONTRACT_SIDE_CONSTRAINT);
                    break;
                case strpos($key, PropertyContractPass::CONTRACT_CODE_CONSTRAINT) !== false :
                    $definition->addTag(PropertyContractPass::CONTRACT_CODE_CONSTRAINT);
                    break;
            }
        }
    }

    private function wireFactory(ContainerBuilder $container, string $name, string $class, string $paramClass): void
    {
        $container->removeDefinition('evrinoma.'.$this->getAlias().'.'.$name.'.factory');
        $definitionFactory = new Definition($class);
        $definitionFactory->addArgument($paramClass);
        $alias = new Alias('evrinoma.'.$this->getAlias().'.'.$name.'.factory');
        $container->addDefinitions(['evrinoma.'.$this->getAlias().'.'.$name.'.factory' => $definitionFactory]);
        $container->addAliases([$class => $alias]);
    }

    private function wireController(ContainerBuilder $container, string $name, string $class): void
    {
        $definitionApiController = $container->getDefinition('evrinoma.'.$this->getAlias().'.'.$name.'.api.controller');
        $definitionApiController->setArgument(5, $class);
    }

    private function wireValidator(ContainerBuilder $container, string $name, string $class): void
    {
        $definitionApiController = $container->getDefinition('evrinoma.'.$this->getAlias().'.'.$name.'.validator');
        $definitionApiController->setArgument(0, $class);
        $definitionApiController->setArgument(1, new Reference('validator'));
    }

    private function wireRepository(ContainerBuilder $container, Reference $doctrineRegistry, string $name, string $class): void
    {
        $definitionRepository = $container->getDefinition('evrinoma.'.$this->getAlias().'.'.$name.'.repository');

        switch ($name) {
            case 'contract':
            case 'side':
                $definitionQueryMediator = $container->getDefinition('evrinoma.'.$this->getAlias().'.'.$name.'.query.mediator');
                $definitionRepository->setArgument(2, $definitionQueryMediator);
            case 'type':
            case 'hierarchy':
                $definitionRepository->setArgument(1, $class);
            default:
                $definitionRepository->setArgument(0, $doctrineRegistry);
        }
        $array = $definitionRepository->getArguments();
        ksort($array);
        $definitionRepository->setArguments($array);

    }
//endregion Private

//region SECTION: Getters/Setters
    public function getAlias()
    {
        return EvrinomaContractBundle::CONTRACT_BUNDLE;
    }
//endregion Getters/Setters
}