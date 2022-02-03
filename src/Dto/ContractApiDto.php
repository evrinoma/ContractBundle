<?php

namespace Evrinoma\ContractBundle\Dto;


use Evrinoma\DtoBundle\Annotation\Dto;
use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\ActiveTrait;
use Evrinoma\DtoCommon\ValueObject\DescriptionTrait;
use Evrinoma\DtoCommon\ValueObject\IdTrait;
use Evrinoma\DtoCommon\ValueObject\NameTrait;
use Evrinoma\DtoCommon\ValueObject\NumberTrait;
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
     */
    public function setTypeApiDto(TypeApiDtoInterface $typeApiDto): void
    {
        $this->typeApiDto = $typeApiDto;
    }

    /**
     * @param HierarchyApiDtoInterface $hierarchyApiDto
     */
    public function setHierarchyApiDto(HierarchyApiDtoInterface $hierarchyApiDto): void
    {
        $this->hierarchyApiDto = $hierarchyApiDto;
    }

    /**
     * @param string $active
     */
    protected function setActive(string $active): void
    {
        $this->active = $active;
    }

    /**
     * @param int|null $id
     */
    protected function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $number
     */
    protected function setNumber(string $number): void
    {
        $this->number = $number;
    }

    /**
     * @param string $description
     */
    protected function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @param string $name
     */
    protected function setName(string $name): void
    {
        $this->name = $name;
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
