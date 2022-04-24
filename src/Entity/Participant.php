<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Participant
 *
 * @ORM\Table(name="participant")
 * @ORM\Entity(repositoryClass="App\Repository\ParticipantRepository")
 */
class Participant
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="Id_participant", type="integer", nullable=false)
     */
    private $idParticipant;

    /**
     * @var int
     *
     * @ORM\Column(name="Id_evenement", type="integer", nullable=false)
     */
    private $idEvenement;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Nbr_reservation", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $nbrReservation = NULL;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Paiement", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $paiement = NULL;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="Date_paiement", type="date", nullable=true, options={"default"="NULL"})
     */
    private $datePaiement = 'NULL';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdParticipant(): ?int
    {
        return $this->idParticipant;
    }

    public function setIdParticipant(int $idParticipant): self
    {
        $this->idParticipant = $idParticipant;

        return $this;
    }

    public function getIdEvenement(): ?int
    {
        return $this->idEvenement;
    }

    public function setIdEvenement(int $idEvenement): self
    {
        $this->idEvenement = $idEvenement;

        return $this;
    }

    public function getNbrReservation(): ?int
    {
        return $this->nbrReservation;
    }

    public function setNbrReservation(?int $nbrReservation): self
    {
        $this->nbrReservation = $nbrReservation;

        return $this;
    }

    public function getPaiement(): ?int
    {
        return $this->paiement;
    }

    public function setPaiement(?int $paiement): self
    {
        $this->paiement = $paiement;

        return $this;
    }

    public function getDatePaiement(): ?\DateTimeInterface
    {
        return $this->datePaiement;
    }

    public function setDatePaiement(?\DateTimeInterface $datePaiement): self
    {
        $this->datePaiement = $datePaiement;

        return $this;
    }


}
