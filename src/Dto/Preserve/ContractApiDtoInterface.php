<?php


namespace Evrinoma\ContractBundle\Dto\Preserve;


interface ContractApiDtoInterface
{
//region SECTION: Getters/Setters
    /**
     * @param string $active
     */
    public function setActive(string $active): void;

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void;

    /**
     * @param string $number
     */
    public function setNumber(string $number): void;

    /**
     * @param string $description
     */
    public function setDescription(string $description): void;

    /**
     * @param string $name
     */
    public function setName(string $name): void;
//endregion Getters/Setters
}