<?php

namespace Evrinoma\ContractBundle\Form\Rest;

use Evrinoma\ContractBundle\Dto\HierarchyApiDto;
use Evrinoma\ContractBundle\Dto\HierarchyApiDtoInterface;
use Evrinoma\ContractBundle\Exception\Hierarchy\HierarchyNotFoundException;
use Evrinoma\ContractBundle\Manager\Hierarchy\QueryManagerInterface;
use Evrinoma\UtilsBundle\Form\Rest\RestChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContractHierarchyChoiceType extends AbstractType
{
//region SECTION: Fields
    private QueryManagerInterface $queryManager;
//endregion Fields

//region SECTION: Constructor
    public function __construct(QueryManagerInterface $queryManager)
    {
        $this->queryManager = $queryManager;
    }
//endregion Constructor

//region SECTION: Public
    public function configureOptions(OptionsResolver $resolver)
    {
        $callback = function (Options $options) {
            $value = [];
            try {
                if ($options->offsetExists('data')) {
                    $criteria = $this->queryManager->criteria(new HierarchyApiDto());
                    switch ($options->offsetGet('data')) {
                        case  HierarchyApiDtoInterface::IDENTITY:
                            foreach ($criteria as $entity) {
                                $value[] = $entity->getIdentity();
                            }
                            break;
                        default:
                            foreach ($criteria as $entity) {
                                $value[] = $entity->getId();
                            }
                    }
                } else {
                    throw new HierarchyNotFoundException();
                }
            } catch (HierarchyNotFoundException $e) {
                $value = RestChoiceType::REST_CHOICES_DEFAULT;
            }

            return $value;
        };
        $resolver->setDefault(RestChoiceType::REST_COMPONENT_NAME, 'hierarchy');
        $resolver->setDefault(RestChoiceType::REST_DESCRIPTION, 'hierarchyList');
        $resolver->setDefault(RestChoiceType::REST_CHOICES, $callback);
    }
//endregion Public

//region SECTION: Getters/Setters
    public function getParent()
    {
        return RestChoiceType::class;
    }
//endregion Getters/Setters
}