<?php

namespace App\Entity;

use App\Repository\FormationsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormationsRepository::class)]
class Formations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $titre = null;

    #[ORM\Column(length: 50)]
    private ?string $reference = null;

    #[ORM\Column(length: 50)]
    private ?string $duree = null;

    #[ORM\Column(length: 100)]
    private ?string $public = null;

    #[ORM\Column(length: 255)]
    private ?string $prerequis = null;

    #[ORM\Column(length: 100)]
    private ?string $tarif = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $objectifs = null;

    #[ORM\Column(length: 100)]
    private ?string $reussite = null;

    #[ORM\Column(length: 100)]
    private ?string $satisfaction = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $effectif = null;

    #[ORM\Column(nullable: true)]
    private ?bool $cpf = null;

    #[ORM\Column(length: 255)]
    private ?string $modalitepedago = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $validation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $acces = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $referencesreglementaires = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $programme = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $modifiedAt = null;

    #[ORM\ManyToOne(inversedBy: 'formations')]
    private ?Equipes $referentpedagogique = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $moyenspedagogiques = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $documents = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(string $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function getPublic(): ?string
    {
        return $this->public;
    }

    public function setPublic(?string $public): static
    {
        $this->public = $public;

        return $this;
    }

    public function getPrerequis(): ?string
    {
        return $this->prerequis;
    }

    public function setPrerequis(?string $prerequis): static
    {
        $this->prerequis = $prerequis;

        return $this;
    }

    public function getTarif(): ?string
    {
        return $this->tarif;
    }

    public function setTarif(string $tarif): static
    {
        $this->tarif = $tarif;

        return $this;
    }

    public function getObjectifs(): ?string
    {
        return $this->objectifs;
    }

    public function setObjectifs(string $objectifs): static
    {
        $this->objectifs = $objectifs;

        return $this;
    }

    public function getReussite(): ?string
    {
        return $this->reussite;
    }

    public function setReussite(string $reussite): static
    {
        $this->reussite = $reussite;

        return $this;
    }

    public function getSatisfaction(): ?string
    {
        return $this->satisfaction;
    }

    public function setSatisfaction(string $satisfaction): static
    {
        $this->satisfaction = $satisfaction;

        return $this;
    }

    public function getEffectif(): ?string
    {
        return $this->effectif;
    }

    public function setEffectif(?string $effectif): static
    {
        $this->effectif = $effectif;

        return $this;
    }

    public function isCpf(): ?bool
    {
        return $this->cpf;
    }

    public function setCpf(?bool $cpf): static
    {
        $this->cpf = $cpf;

        return $this;
    }

    public function getModalitepedago(): ?string
    {
        return $this->modalitepedago;
    }

    public function setModalitepedago(?string $modalitepedago): static
    {
        $this->modalitepedago = $modalitepedago;

        return $this;
    }

    public function getValidation(): ?string
    {
        return $this->validation;
    }

    public function setValidation(?string $validation): static
    {
        $this->validation = $validation;

        return $this;
    }

    public function getAcces(): ?string
    {
        return $this->acces;
    }

    public function setAcces(?string $acces): static
    {
        $this->acces = $acces;

        return $this;
    }

    public function getReferencesreglementaires(): ?string
    {
        return $this->referencesreglementaires;
    }

    public function setReferencesreglementaires(?string $referencesreglementaires): static
    {
        $this->referencesreglementaires = $referencesreglementaires;

        return $this;
    }

    public function getProgramme(): ?string
    {
        return $this->programme;
    }

    public function setProgramme(string $programme): static
    {
        $this->programme = $programme;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getModifiedAt(): ?\DateTimeImmutable
    {
        return $this->modifiedAt;
    }

    public function setModifiedAt(\DateTimeImmutable $modifiedAt): static
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    public function getReferentpedagogique(): ?Equipes
    {
        return $this->referentpedagogique;
    }

    public function setReferentpedagogique(?Equipes $referentpedagogique): static
    {
        $this->referentpedagogique = $referentpedagogique;

        return $this;
    }

    public function getMoyenspedagogiques(): ?string
    {
        return $this->moyenspedagogiques;
    }

    public function setMoyenspedagogiques(string $moyenspedagogiques): static
    {
        $this->moyenspedagogiques = $moyenspedagogiques;

        return $this;
    }

    public function getDocuments(): ?string
    {
        return $this->documents;
    }

    public function setDocuments(string $documents): static
    {
        $this->documents = $documents;

        return $this;
    }


}
