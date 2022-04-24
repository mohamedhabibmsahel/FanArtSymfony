<?php

namespace App\Entity;

use App\Repository\SalleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SalleRepository::class)
 */
class Salle
{
    // /**
    //  * @ORM\Idsalle
    //  * @ORM\GeneratedValue
    //  * @ORM\Column(type="integer")
    //   */

    /**
     * @var int
     *
     * @ORM\Column(name="idsalle", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idsalle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numsalle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nbreplace;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;



    public function getIdsalle(): ?int
    {
        return $this->idsalle;
    }

    public function setIdsalle(int $idsalle): self
    {
        $this->idsalle = $idsalle;

        return $this;
    }

    public function getNumsalle(): ?string
    {
        return $this->numsalle;
    }

    public function setNumsalle(string $numsalle): self
    {
        $this->numsalle = $numsalle;

        return $this;
    }

    public function getNbreplace(): ?string
    {
        return $this->nbreplace;
    }

    public function setNbreplace(string $nbreplace): self
    {
        $this->nbreplace = $nbreplace;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
