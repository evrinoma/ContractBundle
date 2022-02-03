<?php

namespace Evrinoma\ContractBundle\Dto;


use Evrinoma\DtoBundle\Annotation\Dto;
use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\ActiveTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\DescriptionTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\NameTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\NumberTrait;
use Symfony\Component\HttpFoundation\Request;

class ContractApiDto extends AbstractDto implements ContractApiDtoInterface
{
    use IdTrait, ActiveTrait, NameTrait, DescriptionTrait, NumberTrait;

    /**
     * @Dto(class="Evrinoma\ContractBundle\Dto\TypeApiDto", generator="genRequestTypeApiDto")
     * @var TypeApiDtoInterface|null
     */
    private ?TypeApiDtoInterface $typeApiDto = null;

    /**
     * @Dto(class="Evrinoma\ContractBundle\Dto\HierarchyApiDto", generator="genRequestHierarchyApiDto")
     * @var HierarchyApiDtoInterface|null
     */
    private ?HierarchyApiDtoInterface $hierarchyApiDto = null;

    /**
     * @return TypeApiDtoInterface
     */
    public function getTypeApiDto(): TypeApiDtoInterface
    {
        return $this->typeApiDto;
    }

    /**
     * @return HierarchyApiDtoInterface
     */
    public function getHierarchyApiDto(): HierarchyApiDtoInterface
    {
        return $this->hierarchyApiDto;
    }

    /**
     * @return \Generator
     */
    public function genRequestHierarchyApiDto(?Request $request): ?\Generator
    {
        if ($request) {
            $owner = $request->get(HierarchyApiDtoInterface::HIERARCHY);
            if ($owner) {
                $newRequest                     = $this->getCloneRequest();
                $owner[DtoInterface::DTO_CLASS] = HierarchyApiDto::class;
                $newRequest->request->add($owner);

                yield $newRequest;
            }
        }
    }

    /**
     * @return \Generator
     */
    public function genRequestTypeApiDto(?Request $request): ?\Generator
    {
        if ($request) {
            $type = $request->get(TypeApiDtoInterface::TYPE);
            if ($type) {
                $newRequest                    = $this->getCloneRequest();
                $type[DtoInterface::DTO_CLASS] = TypeApiDto::class;
                $newRequest->request->add($type);

                yield $newRequest;
            }
        }
    }

    /**
     * @return bool
     */
    public function hasTypeApiDto(): bool
    {
        return $this->typeApiDto !== null;
    }

    /**
     * @return bool
     */
    public function hasHierarchyApiDto(): bool
    {
        return $this->hierarchyApiDto !== null;
    }

    /**
     * @param TypeApiDtoInterface $typeApiDto
     *
     * @return self
     */
    public function setTypeApiDto(TypeApiDtoInterface $typeApiDto): self
    {
        $this->typeApiDto = $typeApiDto;

        return $this;
    }

    /**
     * @param HierarchyApiDtoInterface $hierarchyApiDto
     *
     * @return self
     */
    public function setHierarchyApiDto(HierarchyApiDtoInterface $hierarchyApiDto): self
    {
        $this->hierarchyApiDto = $hierarchyApiDto;

        return $this;
    }

//region SECTION: Dto
    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {
            $id          = $request->get(ContractApiDtoInterface::ID);
            $active      = $request->get(ContractApiDtoInterface::ACTIVE);
            $description = $request->get(ContractApiDtoInterface::DESCRIPTION);
            $name        = $request->get(ContractApiDtoInterface::NAME, "");
            $number      = $request->get(ContractApiDtoInterface::NUMBER);

            if ($active) {
                $this->setActive($active);
            }

            if ($id) {
                $this->setId($id);
            }

            if ($number != "") {
                $this->setNumber($number);
            }

            if ($name) {
                $this->setName($name);
            }

            if ($description) {
                $this->setDescription($description);
            }
        }

        return $this;
    }
//endregion SECTION: Dto
}
