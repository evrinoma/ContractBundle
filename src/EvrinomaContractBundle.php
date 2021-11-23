<?php


namespace Evrinoma\ContractBundle;

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
        return;
        $container
            ->addCompilerPass(new MapEntityPass($this->getNamespace(), $this->getPath()))
        ;
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