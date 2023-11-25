<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $registration_code = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $vat_no = null;

    #[ORM\Column(length: 455, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $phone = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getRegistrationCode(): ?string
    {
        return $this->registration_code;
    }

    public function setRegistrationCode(string $registration_code): self
    {
        $this->registration_code = $registration_code;

        return $this;
    }

    public function getVatNo(): ?string
    {
        return $this->vat_no;
    }

    public function setVatNo(?string $vat_no): self
    {
        $this->vat_no = $vat_no;

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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }
}
