<?php

namespace Evrinoma\ContractBundle\Dto;

use Evrinoma\CodeBundle\Dto\TypeApiDto;
use Evrinoma\ContractBundle\Model\ModelInterface;
use Evrinoma\DtoBundle\Annotation\Dto;
use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\IdentityTrait;
use Evrinoma\DtoCommon\ValueObject\IdTrait;
use Symfony\Component\HttpFoundation\Request;

class SideApiDto extends AbstractDto implements SideApiDtoInterface
{
    use IdTrait, IdentityTrait;

//region SECTION: Fields
    /**
     * @Dto(class="Evrinoma\ContractBundle\Dto\TypeApiDto", generator="genRequestTypApiDto")
     * @var TypeApiDto|null
     */
    private ?TypeApiDto $typeApiDto = null;
    /**
     * @Dto(class="Evrinoma\ContractBundle\Dto\HierarchyApiDto", generator="genRequestHierarchyApiDto")
     * @var HierarchyApiDto|null
     */
    private ?HierarchyApiDto $hierarchyApiDto = null;
//endregion Fields


//region SECTION: Private
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
//endregion Private

//region SECTION: Dto
    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {
            $id     = $request->get(ModelInterface::ID);
            $active = $request->get(ModelInterface::ACTIVE);

            if ($active) {
                $this->setActive($active);
            }

            if ($id) {
                $this->setId($id);
            }
        }

        return $this;
    }

    public function hasTypeApiDto(): bool
    {
        return $this->typeApiDto !== null;
    }

    public function getTypeApiDto(): TypeApiDto
    {
        return $this->typeApiDto;
    }

    public function hasHierarchyApiDto(): bool
    {
        return $this->hierarchyApiDto !== null;
    }

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
    public function genRequestTypApiDto(?Request $request): ?\Generator
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
//endregion SECTION: Dto
}
