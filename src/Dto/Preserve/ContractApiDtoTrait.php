<?php


namespace Evrinoma\ContractBundle\Dto\Preserve;

use Evrinoma\DtoBundle\Dto\DtoInterface;

trait ContractApiDtoTrait
{
    /**
     * @param string $active
     *
     * @return self|DtoInterface
     */
    public function setActive(string $active): DtoInterface
    {
        return parent::setActive($active);
    }

    /**
     * @param int|null $id
     *
     * @return self|DtoInterface
     */
    public function setId(?int $id): DtoInterface
    {
        return parent::setId($id);
    }

    /**
     * @param string $number
     *
     * @return self|DtoInterface
     */
    public function setNumber(string $number): DtoInterface
    {
        return parent::setNumber($number);
    }

    /**
     * @param string $description
     *
     * @return self|DtoInterface
     */
    public function setDescription(string $description): DtoInterface
    {
        return parent::setDescription($description);
    }

    /**
     * @param string $name
     *
     * @return self|DtoInterface
     */
    public function setName(string $name): DtoInterface
    {
        return parent::setName($name);
    }

}