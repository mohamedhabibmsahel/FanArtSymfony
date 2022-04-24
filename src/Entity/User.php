<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * User
 *
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="email", columns={"email"}), @ORM\UniqueConstraint(name="numtel", columns={"numtel"})})
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields="email", message="Email déjà existant")
 * @UniqueEntity(fields="numtel", message="Numéro de téléphone déjà existant")
 */
class User implements UserInterface, \Serializable
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
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=30, nullable=false)
     * @Assert\NotBlank(message="Nom obligatoire")
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=30, nullable=false)
     * @Assert\NotBlank(message="Prenom obligatoire")
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="mdp", type="string", length=300, nullable=false)
     * @Assert\NotBlank(message="Champs obligatoire")
     * @Assert\Length (min="8", minMessage="Votre mot de passe doit faire minimaum 8 caracteres")
     */
    private $mdp;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Champs obligatoire")
     * @Assert\Email(message="Email invalide")
     */
    private $email;

    /**
     * @var int
     *
     * @ORM\Column(name="numtel", type="integer", nullable=false)
     * @Assert\NotBlank(message="Champs obligatoire")
     * @Assert\Length(
     *      min = 8,
     *      max = 8,
     *      minMessage = "Numéro invalide",
     *      maxMessage = "Numéro invalide"
     * )
     */
    private $numtel;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=1000, nullable=false)
     * @Assert\NotBlank(message="Photo obligatoire")
     */
    private $photo;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=20, nullable=false)
     */
    private $type;
    private $isVerified;
    private $file;

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file): void
    {
        $this->file = $file;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getNumtel(): ?int
    {
        return $this->numtel;
    }
    protected $captchaCode;

    public function getCaptchaCode()
    {
        return $this->captchaCode;
    }

    public function setCaptchaCode($captchaCode)
    {
        $this->captchaCode = $captchaCode;
    }

    public function setNumtel(int $numtel): self
    {
        $this->numtel = $numtel;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }


    public function getRoles()
    {
        return [
            'ROLE_USER'
        ];
    }

    public function getPassword()
    {
        $this->mdp;
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function getUsername()
    {
        $this->email;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public  function  serialize()
    {
        return serialize([
            $this->id,
            $this->nom,
            $this->prenom,
            $this->photo,
            $this->email,
            $this->mdp,
            $this->numtel,
            $this->type

        ]);
    }
    public function  unserialize($string)
    {
        list (
            $this->id,
            $this->nom,
            $this->prenom,
            $this->photo,
            $this->email,
            $this->mdp,
            $this->numtel,
            $this->type
            ) = unserialize($string, ['allowed_classes' => false]);
    }


}
