<?php


namespace Evrinoma\ContractBundle\Dto\Preserve;

trait ContractApiDtoTrait
{
    /**
     * @param string $active
     *
     * @return self
     */
    public function setActive(string $active): self
    {
        return parent::setActive($active);
    }

    /**
     * @param int|null $id
     *
     * @return self
     */
    public function setId(?int $id): self
    {
        return parent::setId($id);
    }

    /**
     * @param string $number
     *
     * @return self
     */
    public function setNumber(string $number): self
    {
        return parent::setNumber($number);
    }

    /**
     * @param string $description
     *
     * @return self
     */
    public function setDescription(string $description): self
    {
        return parent::setDescription($description);
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name): self
    {
        return parent::setName($name);
    }

}