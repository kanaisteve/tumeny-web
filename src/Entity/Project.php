<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private $title;

    #[ORM\Column(type: 'string', length: 100)]
    private $slug;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\Column(type: 'date', nullable: true)]
    private $startDate;

    #[ORM\Column(type: 'date', nullable: true)]
    private $endDate;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $assignee;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $status;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $category;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $technologies;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $client;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $url;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $imagePath;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $slide1;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $slide2;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $slide3;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

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

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getAssignee(): ?string
    {
        return $this->assignee;
    }

    public function setAssignee(?string $assignee): self
    {
        $this->assignee = $assignee;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getTechnologies(): ?string
    {
        return $this->technologies;
    }

    public function setTechnologies(?string $technologies): self
    {
        $this->technologies = $technologies;

        return $this;
    }

    public function getClient(): ?string
    {
        return $this->client;
    }

    public function setClient(?string $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(?string $imagePath): self
    {
        $this->imagePath = $imagePath;

        return $this;
    }

    public function getSlide1(): ?string
    {
        return $this->slide1;
    }

    public function setSlide1(?string $slide1): self
    {
        $this->slide1 = $slide1;

        return $this;
    }

    public function getSlide2(): ?string
    {
        return $this->slide2;
    }

    public function setSlide2(?string $slide2): self
    {
        $this->slide2 = $slide2;

        return $this;
    }

    public function getSlide3(): ?string
    {
        return $this->slide3;
    }

    public function setSlide3(?string $slide3): self
    {
        $this->slide3 = $slide3;

        return $this;
    }
}
