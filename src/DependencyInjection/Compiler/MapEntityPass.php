<?php

namespace Evrinoma\ContractBundle\DependencyInjection\Compiler;

use Doctrine\Common\Annotations\AnnotationReader;
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
use ReflectionClass;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Doctrine\ORM\Mapping;

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
                BaseHierarchy::class => [HierarchyInterface::class => [],],
                BaseType::class      => [TypeInterface::class => [],],
            ],
            false
        );

//        $entityBunch = $container->getParameter('evrinoma.contract.entity_side');
//        if ((strpos($entityBunch, EvrinomaContractExtension::ENTITY) !== false)) {
//            $annotationReader = new AnnotationReader();
//            $reflectionClass = new ReflectionClass(BaseContract::class);
//            $joinTableAttribute = $annotationReader->getClassAnnotation($reflectionClass, Mapping\Table::class);
//
//            $joinTableAttribute->name
//            $this->loadMetadata($driver, $referenceAnnotationReader, '%s/Model/Side', '%s/Entity/Side');
//            $this->addResolveTargetEntity([BaseSide::class => [LeftSideInterface::class => ['joinTable' => ['name' => 'qweqweqw']], RightSideInterface::class => ['SUPER' => 'Right'],],], false);
//        }
//
//        $entityCode = $container->getParameter('evrinoma.contract.entity_contract');
//
//        if ((strpos($entityCode, EvrinomaContractExtension::ENTITY) !== false)) {
//            $this->loadMetadata($driver, $referenceAnnotationReader, '%s/Model/Contract', '%s/Entity/Contract');
//            $this->addResolveTargetEntity([BaseContract::class => [ContractInterface::class => [],],], false);
//        }


        $entityContract = $container->getParameter('evrinoma.contract.entity_contract');
        if ((strpos($entityContract, EvrinomaContractExtension::ENTITY) !== false)) {
            $this->loadMetadata($driver, $referenceAnnotationReader, '%s/Model/Contract', '%s/Entity/Contract');
        }
        $this->addResolveTargetEntity([$entityContract => [ContractInterface::class => [],],], false);

        $entitySide = $container->getParameter('evrinoma.contract.entity_side');
        if ((strpos($entitySide, EvrinomaContractExtension::ENTITY) !== false)) {
            $this->loadMetadata($driver, $referenceAnnotationReader, '%s/Model/Side', '%s/Entity/Side');
        }

        $mapping = $this->getMapping($entitySide);
        $this->addResolveTargetEntity([$entitySide => [LeftSideInterface::class => ['joinTable' => $mapping], RightSideInterface::class => ['joinTable' => $mapping],],], false);

    }

    private function getMapping(string $className): array
    {
        $annotationReader   = new AnnotationReader();
        $reflectionClass    = new ReflectionClass($className);
        $joinTableAttribute = $annotationReader->getClassAnnotation($reflectionClass, Mapping\Table::class);

        return ($joinTableAttribute) ? ['name' => $joinTableAttribute->name] : [];
    }


//endregion Private
}