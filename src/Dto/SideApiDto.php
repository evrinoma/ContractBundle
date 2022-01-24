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
    use IdTrait;

    /**
     * @Dto(class="Evrinoma\ContractBundle\Dto\ContractApiDto", generator="genRequestRightContractApiDto")
     * @var ContractApiDto|null
     */
    private ?ContractApiDto $left = null;
    /**
     * @Dto(class="Evrinoma\ContractBundle\Dto\ContractApiDto", generator="genRequestLeftContractApiDto")
     * @var ContractApiDto|null
     */
    private ?ContractApiDto $right = null;
//region SECTION: Private

    /**
     * @return bool
     */
    public function hasLeft(): bool
    {
        return $this->left !== null;
    }

    /**
     * @return bool
     */
    public function hasRight(): bool
    {
        return $this->right !== null;
    }

    /**
     * @param int|null $id
     */
    protected function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param ContractApiDtoInterface $left
     */
    public function setLeft(ContractApiDtoInterface $left): void
    {
        $this->left = $left;
    }

    /**
     * @param ContractApiDtoInterface $right
     */
    public function setRight(ContractApiDtoInterface $right): void
    {
        $this->right = $right;
    }

    /**
     * @return \Generator
     */
    public function genRequestRightContractApiDto(?Request $request): ?\Generator
    {
        if ($request) {
            $type = $request->get('left');
            if ($type) {
                $newRequest                    = $this->getCloneRequest();
                $type[DtoInterface::DTO_CLASS] = ContractApiDto::class;
                $newRequest->request->add($type);

                yield $newRequest;
            }
        }
    }

    /**
     * @return \Generator
     */
    public function genRequestLeftContractApiDto(?Request $request): ?\Generator
    {
        if ($request) {
            $type = $request->get('right');
            if ($type) {
                $newRequest                    = $this->getCloneRequest();
                $type[DtoInterface::DTO_CLASS] = ContractApiDto::class;
                $newRequest->request->add($type);

                yield $newRequest;
            }
        }
    }
//endregion Private

//region SECTION: Dto
    /**
     * @param Request $request
     *
     * @return DtoInterface
     */
    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {
            $id = $request->get(ModelInterface::ID);
            if ($id) {
                $this->setId($id);
            }
        }

        return $this;
    }
//endregion SECTION: Dto

    /**
     * @return ContractApiDtoInterface
     */
    public function getLeft(): ContractApiDtoInterface
    {
        return $this->left;
    }

    /**
     * @return ContractApiDtoInterface
     */
    public function getRight(): ContractApiDtoInterface
    {
        return $this->right;
    }
}
