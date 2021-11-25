<?php

namespace Evrinoma\ContractBundle\DependencyInjection\Compiler;


use Evrinoma\ContractBundle\EvrinomaContractBundle;
use Symfony\Component\DependencyInjection\Compiler\AbstractRecursivePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DecoratorPass extends AbstractRecursivePass
{
//region SECTION: Public
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        $decoratorQuery = $container->getParameter('evrinoma.'.EvrinomaContractBundle::CONTRACT_BUNDLE.'.decorates.contract.query');
        if ($decoratorQuery) {
            $queryMediator = $container->getDefinition($decoratorQuery);
            $repository    = $container->getDefinition('evrinoma.'.EvrinomaContractBundle::CONTRACT_BUNDLE.'.contract.repository');
            $repository->setArgument(2, $queryMediator);
        }
        $decoratorCommand = $container->getParameter('evrinoma.'.EvrinomaContractBundle::CONTRACT_BUNDLE.'.decorates.contract.command');
        if ($decoratorCommand) {
            $commandMediator = $container->getDefinition($decoratorCommand);
            $commandManager  = $container->getDefinition('evrinoma.'.EvrinomaContractBundle::CONTRACT_BUNDLE.'.contract.command.manager');
            $commandManager->setArgument(3, $commandMediator);
        }

        $decoratorQuery = $container->getParameter('evrinoma.'.EvrinomaContractBundle::CONTRACT_BUNDLE.'.decorates.side.query');
        if ($decoratorQuery) {
            $queryMediator = $container->getDefinition($decoratorQuery);
            $repository    = $container->getDefinition('evrinoma.'.EvrinomaContractBundle::CONTRACT_BUNDLE.'.side.repository');
            $repository->setArgument(2, $queryMediator);
        }
        $decoratorCommand = $container->getParameter('evrinoma.'.EvrinomaContractBundle::CONTRACT_BUNDLE.'.decorates.side.command');
        if ($decoratorCommand) {
            $commandMediator = $container->getDefinition($decoratorCommand);
            $commandManager  = $container->getDefinition('evrinoma.'.EvrinomaContractBundle::CONTRACT_BUNDLE.'.side.command.manager');
            $commandManager->setArgument(3, $commandMediator);
        }
    }
}