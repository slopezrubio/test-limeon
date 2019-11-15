<?php

namespace App\Entity;

use App\Validator\Constraints\Alpha;
use App\Validator\Constraints\MaxNumberOfWords;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="actions")
 * @ORM\Entity(repositoryClass="App\Repository\ActionRepository")
 */
class Action
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Building")
     * @ORM\JoinColumn(nullable=false)
     */
    private $building;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Apartment")
     * @ORM\JoinColumn(nullable=false)
     */
    private $apartment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Room")
     */
    private $room;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="date")
     */
    private $date_of_work;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $responsable;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email_responsable;

    /**
     * @ORM\Column(type="text")
     */
    private $phone_number_responsable;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $attached_files;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBuilding(): ?Building
    {
        return $this->building;
    }

    public function setBuilding(?Building $building): self
    {
        $this->building = $building;

        return $this;
    }

    public function getApartment(): ?Apartment
    {
        return $this->apartment;
    }

    public function setApartment(?Apartment $apartment): self
    {
        $this->apartment = $apartment;

        return $this;
    }

    public function getRoom(): ?Room
    {
        return $this->room;
    }

    public function setRoom(?Room $room): self
    {
        $this->room = $room;

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

    public function getDateOfWork(): ?\DateTimeInterface
    {
        return $this->date_of_work;
    }

    public function setDateOfWork(\DateTimeInterface $date_of_work): self
    {
        $this->date_of_work = $date_of_work;

        return $this;
    }

    public function getResponsable(): ?string
    {
        return $this->responsable;
    }

    public function setResponsable(string $responsable): self
    {
        $this->responsable = $responsable;

        return $this;
    }

    public function getEmailResponsable(): ?string
    {
        return $this->email_responsable;
    }

    public function setEmailResponsable(?string $email_responsable): self
    {
        $this->email_responsable = $email_responsable;

        return $this;
    }

    public function getPhoneNumberResponsable(): ?string
    {
        return $this->phone_number_responsable;
    }

    public function setPhoneNumberResponsable(string $prefixes, string $phone_number_responsable): self
    {
        $this->phone_number_responsable = json_encode([
            'prefix' => $prefixes,
            'phone_number' => $phone_number_responsable
        ]);

        return $this;
    }

    public function getAttachedFiles(): ?string
    {
        return $this->attached_files;
    }

    public function setAttachedFiles(?string $attached_files): self
    {
        $this->attached_files = $attached_files;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata) {
        $metadata->addPropertyConstraint('building', new Assert\NotBlank());
        $metadata->addPropertyConstraint('apartment', new Assert\NotBlank());
        $metadata->addPropertyConstraint('room', new Assert\NotBlank());
        $metadata->addPropertyConstraint('description', new MaxNumberOfWords());
        $metadata->addPropertyConstraint('description', new Assert\NotBlank());
        $metadata->addPropertyConstraint('responsable', new Assert\NotBlank());
        $metadata->addPropertyConstraint('responsable', new Alpha());
        $metadata->addPropertyConstraint('phone_number_responsable', new Assert\NotBlank());
        $metadata->addPropertyConstraint('phone_number_responsable', new Assert\Regex([
            'pattern' => '/^[0-9]{9,10}$/',
            'match' =>  true,
            'message' => 'The phone number is invalid.'
        ]));
        $metadata->addPropertyConstraint('email_responsable', new Assert\Email([
            'message' => 'The email is not valid'
        ]));
        $metadata->addPropertyConstraint('email_responsable', new Assert\NotBlank());
        $metadata->addPropertyConstraint('date_of_work', new Assert\Date());
        $metadata->addPropertyConstraint('date_of_work', new Assert\NotBlank());
        $metadata->addPropertyConstraint('date_of_work', new Assert\NotNull());
    }
}
