<?php
namespace App\Entity;

class PropertySearch {

    /**
     * @var int|null
     */
    private $maxprice;

    /**
     * @return int|null
     */
    public function getMaxprice(): ?int
    {
        return $this->maxprice;
    }

    /**
     * @param int|null $maxprice
     */
    public function setMaxprice(int $maxprice): void
    {
        $this->maxprice = $maxprice;
    }

}