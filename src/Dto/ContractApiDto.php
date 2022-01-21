<?php

namespace Evrinoma\ContractBundle\Dto;

use Evrinoma\ContractBundle\Model\ModelInterface;
use Evrinoma\DtoBundle\Annotation\Dto;
use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\ActiveTrait;
use Evrinoma\DtoCommon\ValueObject\DescriptionTrait;
use Evrinoma\DtoCommon\ValueObject\IdTrait;
use Evrinoma\DtoCommon\ValueObject\NameTrait;
use Symfony\Component\HttpFoundation\Request;

class ContractApiDto extends AbstractDto implements ContractApiDtoInterface
{
    use IdTrait, ActiveTrait, NameTrait, DescriptionTrait;

    /**
     * @Dto(class="Evrinoma\ContractBundle\Dto\TypeApiDto", generator="genRequestTypeApiDto")
     * @var TypeApiDto|null
     */
    private ?TypeApiDto $typeApiDto = null;

    /**
     * @Dto(class="Evrinoma\ContractBundle\Dto\HierarchyApiDto", generator="genRequestHierarchyApiDto")
     * @var HierarchyApiDto|null
     */
    private ?HierarchyApiDto $hierarchyApiDto = null;

    /**
     * @return TypeApiDto
     */
    public function getTypeApiDto(): TypeApiDto
    {
        return $this->typeApiDto;
    }

    /**
     * @return HierarchyApiDto
     */
    public function getHierarchyApiDto(): HierarchyApiDto
    {
        return $this->hierarchyApiDto;
    }

    /**
     * @return \Generator
     */
    public function genRequestHierarchyApiDto(?Request $request): ?\Generator
    {
        if ($request) {
            $owner = $request->get('hierarchy');
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
            $type = $request->get('type');
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
     * @param TypeApiDto $typeApiDto
     */
    public function setTypeApiDto(TypeApiDto $typeApiDto): void
    {
        $this->typeApiDto = $typeApiDto;
    }

    /**
     * @param HierarchyApiDto $hierarchyApiDto
     */
    public function setHierarchyApiDto(HierarchyApiDto $hierarchyApiDto): void
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
            $id          = $request->get(ModelInterface::ID);
            $active      = $request->get(ModelInterface::ACTIVE);
            $description = $request->get(ModelInterface::DESCRIPTION);
            $name        = $request->get(ModelInterface::NAME);

            if ($active) {
                $this->setActive($active);
            }

            if ($id) {
                $this->setId($id);
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
