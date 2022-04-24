<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recevent
 *
 * @ORM\Table(name="recevent")
 * @ORM\Entity(repositoryClass="App\Repository\ReceventRepository")
 */
class Recevent
{
    /**
     * @var int
     *
     * @ORM\Column(name="receid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $receid;

    /**
     * @var string
     *
     * @ORM\Column(name="nomevent", type="string", length=50, nullable=false)
     */
    private $nomevent;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="reclevent", type="text", length=65535, nullable=false)
     */
    private $reclevent;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=20, nullable=false)
     */
    private $status;

    public function getReceid(): ?int
    {
        return $this->receid;
    }

    public function getNomevent(): ?string
    {
        return $this->nomevent;
    }

    public function setNomevent(string $nomevent): self
    {
        $this->nomevent = $nomevent;

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

    public function getReclevent(): ?string
    {
        return $this->reclevent;
    }

    public function setReclevent(string $reclevent): self
    {
        $this->reclevent = $reclevent;

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
