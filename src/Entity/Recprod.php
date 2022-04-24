<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recprod
 *
 * @ORM\Table(name="recprod")
 * @ORM\Entity(repositoryClass="App\Repository\RecprodRepository")
 */
class Recprod
{
    /**
     * @var int
     *
     * @ORM\Column(name="recpid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $recpid;

    /**
     * @var string
     *
     * @ORM\Column(name="nomprod", type="string", length=50, nullable=false)
     */
    private $nomprod;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="reclprod", type="text", length=65535, nullable=false)
     */
    private $reclprod;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=20, nullable=false)
     */
    private $status;

    public function __toString()
    {
        return $this->nomprod;
    }

    public function getRecpid(): ?int
    {
        return $this->recpid;
    }

    public function getNomprod(): ?string
    {
        return $this->nomprod;
    }

    public function setNomprod(string $nomprod): self
    {
        $this->nomprod = $nomprod;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getReclprod(): ?string
    {
        return $this->reclprod;
    }

    public function setReclprod(string $reclprod): self
    {
        $this->reclprod = $reclprod;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }




}
