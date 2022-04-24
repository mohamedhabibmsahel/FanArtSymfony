<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PanierElem
 *
 * @ORM\Table(name="panier_elem", indexes={@ORM\Index(name="id_panier", columns={"id_panier"}), @ORM\Index(name="FK_id_produit", columns={"id_produit"})})
 * @ORM\Entity(repositoryClass="App\Repository\PanierElemRepository")
 */
class PanierElem
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_panier", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idPanier;

    /**
     * @var int
     *
     * @ORM\Column(name="id_produit", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idProduit;

    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer", nullable=false)
     */
    private $quantite;

    public function getIdPanier(): ?int
    {
        return $this->idPanier;
    }

    public function getIdProduit(): ?int
    {
        return $this->idProduit;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }


}
