<?php

namespace Evrinoma\ContractBundle\Dto;

use Evrinoma\DtoBundle\Annotation\Dto;
use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdTrait;
use Symfony\Component\HttpFoundation\Request;

class SideApiDto extends AbstractDto implements SideApiDtoInterface
{
    use IdTrait;

    /**
     * @Dto(class="Evrinoma\ContractBundle\Dto\ContractApiDto", generator="genRequestRightContractApiDto")
     * @var ContractApiDtoInterface|null
     */
    private ?ContractApiDtoInterface $left = null;
    /**
     * @Dto(class="Evrinoma\ContractBundle\Dto\ContractApiDto", generator="genRequestLeftContractApiDto")
     * @var ContractApiDtoInterface|null
     */
    private ?ContractApiDtoInterface $right = null;
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
     * @param ContractApiDtoInterface $left
     *
     * @return DtoInterface
     */
    public function setLeft(ContractApiDtoInterface $left): DtoInterface
    {
        $this->left = $left;

        return $this;
    }

    /**
     * @param ContractApiDtoInterface $right
     *
     * @return DtoInterface
     */
    public function setRight(ContractApiDtoInterface $right): DtoInterface
    {
        $this->right = $right;

        return $this;
    }

    /**
     * @return \Generator
     */
    public function genRequestRightContractApiDto(?Request $request): ?\Generator
    {
        if ($request) {
            $type = $request->get(SideApiDtoInterface::LEFT);
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
            $type = $request->get(SideApiDtoInterface::RIGHT);
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
            $id = $request->get(SideApiDtoInterface::ID);
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
