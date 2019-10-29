<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Room", inversedBy="actions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $room;

    /**
     * @ORM\Column(type="text", nullable=true)
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
     * @ORM\Column(type="string", length=255)
     */
    private $email_responsable;

    /**
     * @ORM\Column(type="text")
     */
    private $phone_number_responsable = [];

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $attached_files = [];

    public function getId(): ?int
    {
        return $this->id;
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

    public function setDescription(?string $description): self
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

    public function setEmailResponsable(string $email_responsable): self
    {
        $this->email_responsable = $email_responsable;

        return $this;
    }

    public function getPhoneNumberResponsable(): ?array
    {
        return $this->phone_number_responsable;
    }

    public function setPhoneNumberResponsable(array $phone_number_responsable): self
    {
        $this->phone_number_responsable = $phone_number_responsable;

        return $this;
    }

    public function getAttachedFiles(): ?array
    {
        return $this->attached_files;
    }

    public function setAttachedFiles(?array $attached_files): self
    {
        $this->attached_files = $attached_files;

        return $this;
    }


}
