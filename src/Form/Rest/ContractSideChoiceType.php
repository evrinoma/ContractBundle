<?php

namespace Evrinoma\ContractBundle\Form\Rest;


use Evrinoma\ContractBundle\Dto\SideApiDto;
use Evrinoma\ContractBundle\Exception\Side\SideNotFoundException;
use Evrinoma\ContractBundle\Exception\Type\TypeNotFoundException;
use Evrinoma\ContractBundle\Manager\Side\QueryManagerInterface;
use Evrinoma\UtilsBundle\Form\Rest\RestChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContractSideChoiceType extends AbstractType
{

//region SECTION: Fields
    private QueryManagerInterface $queryManager;
    private static string         $dtoClass = SideApiDto::class;
//endregion Fields

//region SECTION: Constructor
    public function __construct(QueryManagerInterface $queryManager, string $entityClass)
    {
        self::$dtoClass     = $entityClass;
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
                    $criteria = $this->queryManager->criteria(new self::$dtoClass);
                    switch ($options->offsetGet('data')) {
                        default:
                            foreach ($criteria as $entity) {
                                $value[] = $entity->getId();
                            }
                    }
                } else {
                    throw new SideNotFoundException();
                }
            } catch (SideNotFoundException $e) {
                $value = RestChoiceType::REST_CHOICES_DEFAULT;
            }

            return $value;
        };
        $resolver->setDefault(RestChoiceType::REST_COMPONENT_NAME, 'side');
        $resolver->setDefault(RestChoiceType::REST_DESCRIPTION, 'sideList');
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