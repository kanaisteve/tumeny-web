<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfileRepository::class)]
class Profile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $avatar;

    #[ORM\Column(type: 'text', nullable: true)]
    private $about;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $facebook;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $twitter;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $linkedin;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $intagram;

    #[ORM\Column(type: 'date', nullable: true)]
    private $birthDate;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $idNumber;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private $gender;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $firstName;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $lastName;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $country;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $province;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $city;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $address;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $nrcFront;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $nrcBack;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getAbout(): ?string
    {
        return $this->about;
    }

    public function setAbout(?string $about): self
    {
        $this->about = $about;

        return $this;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(?string $facebook): self
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    public function setTwitter(?string $twitter): self
    {
        $this->twitter = $twitter;

        return $this;
    }

    public function getLinkedin(): ?string
    {
        return $this->linkedin;
    }

    public function setLinkedin(?string $linkedin): self
    {
        $this->linkedin = $linkedin;

        return $this;
    }

    public function getIntagram(): ?string
    {
        return $this->intagram;
    }

    public function setIntagram(?string $intagram): self
    {
        $this->intagram = $intagram;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getIdNumber(): ?int
    {
        return $this->idNumber;
    }

    public function setIdNumber(?int $idNumber): self
    {
        $this->idNumber = $idNumber;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getProvince(): ?string
    {
        return $this->province;
    }

    public function setProvince(?string $province): self
    {
        $this->province = $province;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getNrcFront(): ?string
    {
        return $this->nrcFront;
    }

    public function setNrcFront(?string $nrcFront): self
    {
        $this->nrcFront = $nrcFront;

        return $this;
    }

    public function getNrcBack(): ?string
    {
        return $this->nrcBack;
    }

    public function setNrcBack(string $nrcBack): self
    {
        $this->nrcBack = $nrcBack;

        return $this;
    }
}
