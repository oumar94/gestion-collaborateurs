<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Exception;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CollaboratorRepository")
 * @Vich\Uploadable
 */
class Collaborator
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_dispo;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_depart_prevue;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    /**
     * @var File|null
     * @Assert\Image(mimeTypes={"image/jpeg","image/png"})
     * @Vich\UploadableField(mapping="collaborator_image", fileNameProperty="filename")
     */
    private $imageFile;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ActualStatus", inversedBy="collaborators")
     * @ORM\JoinColumn(nullable=false)
     */
    private $actualStatus;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Client", inversedBy="collaborators")
     */
    private $clients;

    /**
     * @ORM\Column(type="date")
     */
    private $date_affectation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $remplacant_prevu;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\OperatingMode", inversedBy="collaborators")
     */
    private $operating_mode;

    public function __construct()
    {
        $this->clients = new ArrayCollection();
    }

    /**
     * @return File|null
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param File|null $imageFile
     * @return Collaborator
     * @throws Exception
     */
    public function setImageFile(?File $imageFile): Collaborator
    {
        $this->imageFile = $imageFile;
        return $this;
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

    public function getDateDispo(): ?\DateTimeInterface
    {
        return $this->date_dispo;
    }

    public function setDateDispo(?\DateTimeInterface $date_dispo): self
    {
        $this->date_dispo = $date_dispo;

        return $this;
    }

    public function getDateDepartPrevue(): ?\DateTimeInterface
    {
        return $this->date_depart_prevue;
    }

    public function setDateDepartPrevue(?\DateTimeInterface $date_depart_prevue): self
    {
        $this->date_depart_prevue = $date_depart_prevue;

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getActualStatus(): ?ActualStatus
    {
        return $this->actualStatus;
    }

    public function setActualStatus(?ActualStatus $actualStatus): self
    {
        $this->actualStatus = $actualStatus;

        return $this;
    }

    /**
     * @return Collection|Client[]
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(Client $client): self
    {
        if (!$this->clients->contains($client)) {
            $this->clients[] = $client;
            $client->addCollaborator($this);
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        if ($this->clients->contains($client)) {
            $this->clients->removeElement($client);
            $client->removeCollaborator($this);
        }

        return $this;
    }

    public function getDateAffectation(): ?\DateTimeInterface
    {
        return $this->date_affectation;
    }

    public function setDateAffectation(\DateTimeInterface $date_affectation): self
    {
        $this->date_affectation = $date_affectation;

        return $this;
    }

    public function getRemplacantPrevu(): ?string
    {
        return $this->remplacant_prevu;
    }

    public function setRemplacantPrevu(?string $remplacant_prevu): self
    {
        $this->remplacant_prevu = $remplacant_prevu;

        return $this;
    }

    public function getOperatingMode(): ?OperatingMode
    {
        return $this->operating_mode;
    }

    public function setOperatingMode(?OperatingMode $operating_mode): self
    {
        $this->operating_mode = $operating_mode;

        return $this;
    }
}
