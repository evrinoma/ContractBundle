<?php


namespace Evrinoma\ContractBundle\Dto\Preserve;

trait ContractApiDtoTrait
{
    /**
     * @param string $active
     */
    public function setActive(string $active): void
    {
        parent::setActive($active);
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        parent::setId($id);
    }

    /**
     * @param string $number
     */
    public function setNumber(string $number): void
    {
        parent::setNumber($number);
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        parent::setDescription($description);
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        parent::setName($name);
    }

}