<?php

namespace Evrinoma\ContractBundle\DependencyInjection\Compiler;

use Evrinoma\ContractBundle\DependencyInjection\EvrinomaContractExtension;
use Evrinoma\ContractBundle\Entity\Contract\BaseContract;
use Evrinoma\ContractBundle\Entity\Define\BaseHierarchy;
use Evrinoma\ContractBundle\Entity\Define\BaseType;
use Evrinoma\ContractBundle\Entity\Side\BaseSide;
use Evrinoma\ContractBundle\Model\Contract\ContractInterface;
use Evrinoma\ContractBundle\Model\Define\HierarchyInterface;
use Evrinoma\ContractBundle\Model\Define\TypeInterface;
use Evrinoma\ContractBundle\Model\Side\LeftSideInterface;
use Evrinoma\ContractBundle\Model\Side\RightSideInterface;
use Evrinoma\UtilsBundle\DependencyInjection\Compiler\AbstractMapEntity;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class MapEntityPass extends AbstractMapEntity implements CompilerPassInterface
{
//region SECTION: Public
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        $this->setContainer($container);

        $driver                    = $container->findDefinition('doctrine.orm.default_metadata_driver');
        $referenceAnnotationReader = new Reference('annotations.reader');

        $this->cleanMetadata($driver, [EvrinomaContractExtension::ENTITY]);

        /** load default entities*/
        $this->loadMetadata($driver, $referenceAnnotationReader, '%s/Model/Define', '%s/Entity/Define');
        $this->addResolveTargetEntity(
            [
                BaseHierarchy::class => HierarchyInterface::class,
                BaseType::class      => TypeInterface::class,
            ],
            false
        );

        $entityBunch = $container->getParameter('evrinoma.contract.entity_side');
        if ((strpos($entityBunch, EvrinomaContractExtension::ENTITY) !== false)) {
            $this->loadMetadata($driver, $referenceAnnotationReader, '%s/Model/Side', '%s/Entity/Side');
            $this->addResolveTargetEntity([BaseSide::class => LeftSideInterface::class,], false);
            $this->addResolveTargetEntity([BaseSide::class => RightSideInterface::class,], false);
        }

        $entityCode = $container->getParameter('evrinoma.contract.entity_contract');

        if ((strpos($entityCode, EvrinomaContractExtension::ENTITY) !== false)) {
            $this->loadMetadata($driver, $referenceAnnotationReader, '%s/Model/Contract', '%s/Entity/Contract');
            $this->addResolveTargetEntity([BaseContract::class => ContractInterface::class,], false);
        }
    }


//endregion Private
}