<?php


namespace Evrinoma\ContractBundle;

use Evrinoma\ContractBundle\DependencyInjection\Compiler\Constraint\Complex\ContractPass;
use Evrinoma\ContractBundle\DependencyInjection\Compiler\Constraint\Complex\SidePass;
use Evrinoma\ContractBundle\DependencyInjection\Compiler\Constraint\Property\ContractPass as PropertyContractPass;
use Evrinoma\ContractBundle\DependencyInjection\Compiler\Constraint\Property\HierarchyPass as PropertyHierarchyPass;
use Evrinoma\ContractBundle\DependencyInjection\Compiler\Constraint\Property\SidePass as PropertySidePass;
use Evrinoma\ContractBundle\DependencyInjection\Compiler\Constraint\Property\TypePass as PropertyTypePass;
use Evrinoma\ContractBundle\DependencyInjection\Compiler\DecoratorPass;
use Evrinoma\ContractBundle\DependencyInjection\Compiler\MapEntityPass;
use Evrinoma\ContractBundle\DependencyInjection\EvrinomaContractExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;


/**
 * Class ContractBundle
 *
 * @package Evrinoma\ContractBundle
 */
class EvrinomaContractBundle extends Bundle
{
//region SECTION: Fields
    public const CONTRACT_BUNDLE = 'contract';
//endregion Fields

//region SECTION: Public
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container
            ->addCompilerPass(new MapEntityPass($this->getNamespace(), $this->getPath()))
            ->addCompilerPass(new DecoratorPass())
            ->addCompilerPass(new PropertyContractPass())
            ->addCompilerPass(new PropertyTypePass())
            ->addCompilerPass(new PropertyHierarchyPass())
            ->addCompilerPass(new PropertySidePass())
            ->addCompilerPass(new SidePass())
            ->addCompilerPass(new ContractPass());
    }
//endregion Public

//region SECTION: Getters/Setters
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new EvrinomaContractExtension();
        }

        return $this->extension;
    }
//endregion Getters/Setters
}