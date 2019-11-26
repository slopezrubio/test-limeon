<?php

namespace App\Entity;

use App\Validator\Constraints\Alpha;
use App\Validator\Constraints\MaxNumberOfWords;
use App\Validator\Constraints\MultipleFiles;
use Doctrine\ORM\Mapping as ORM;
use Faker\Provider\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\FileUploader;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="actions")
 * @ORM\Entity(repositoryClass="App\Repository\ActionRepository")
 * @ORM\HasLifecycleCallbacks()
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
     * @ORM\Column(type="string", nullable=true)
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

    public function getPrefix(): ?string
    {
        return json_decode($this->phone_number_responsable)->prefix;
    }

    public function getPhoneNumber(): ?array
    {
        return (array) json_decode($this->phone_number_responsable)->phone_number;
    }

    public function getPhoneNumberResponsable(): ?array
    {
        return (array) json_decode($this->phone_number_responsable);
    }

    public function setPhoneNumberResponsable(string $prefix, string $phone_number_responsable): self
    {
        $this->phone_number_responsable = json_encode([
            'prefix' => $prefix,
            'phone_number' => $phone_number_responsable
        ]);

        return $this;
    }

    public function getAttachedFiles()
    {
        return $this->attached_files;
    }

    public function setAttachedFiles(?array $attached_files): self
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

    public static function encodeFields(?array $actions, ?array $fields) {
        $actionsDecoded = [];
        foreach ($actions as $property => $action) {
            for ($i = 0; $i < count($fields); $i++) {
                $action['action'][$fields[$i]] = (array) json_decode($action['action'][$fields[$i]]);
            }
            array_push($actionsDecoded, $action);
        }

        return $actionsDecoded;
    }

    public function uploadAttachedFiles(?FileUploader $fileUploader) {
        if (!empty($this->getAttachedFiles())) {
            $files = [];
            foreach ($this->getAttachedFiles() as $index => $fileUploadedObject) {
                $files[$index]['fileName'] = $fileUploader->upload($fileUploadedObject);
                $files[$index]['originalFileName'] = $fileUploadedObject->getClientOriginalName();
            }
            $this->setAttachedFiles($files);
        }
    }

    /**
     * @ORM\PrePersist
     *
     * Encode all the attached files submitted by the user with the properties
     * that comes within the UploadedFile class.
     *
     * @see UploadedFile
     */
    public function setAttachedFilesValue() {

        $attachedFilesEncoded = [];
        foreach ($this->getAttachedFiles() as $index => $file) {
            if ($file instanceof UploadedFile) {
                $fileDetails = [];
                foreach ((array)$file as $key => $value) {
                    $fileDetails[explode("\0", $key)[count(explode("\0", $key)) - 1]] = $value;
                }
                array_push($attachedFilesEncoded, json_encode($fileDetails));
                //$attachedFilesEncoded[$index] = $fileDetails;
            } else {
                array_push($attachedFilesEncoded, json_encode($file));
            }
        }

        $this->attached_files = json_encode($attachedFilesEncoded);
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
        $metadata->addGetterConstraint('phoneNumber', new Assert\Regex([
            'pattern' => '/^[0-9]{9,10}$/',
            'message' => 'The phone number is invalid.'
        ]));
        $metadata->addPropertyConstraint('email_responsable', new Assert\Email([
            'message' => 'The email is not valid'
        ]));
        $metadata->addPropertyConstraint('email_responsable', new Assert\NotBlank());
        $metadata->addPropertyConstraint('date_of_work', new Assert\Date());
        $metadata->addPropertyConstraint('date_of_work', new Assert\NotBlank());
        $metadata->addPropertyConstraint('date_of_work', new Assert\NotNull());
        $metadata->addPropertyConstraint('attached_files', new Assert\All([
            'constraints' => new Assert\File([
                'maxSize' => '2048k',
                'mimeTypes' => [
                    'application/pdf',
                    'application/x-pdf',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/msword',
                    'application/vnd.oasis.opendocument.text'
                ],
                'mimeTypesMessage' => 'Unsupported file please be sure to upload a valid PDF, DOC, DOCX or ODT document',
            ])
        ]));
    }
}
