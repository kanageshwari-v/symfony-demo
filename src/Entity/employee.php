<?php

namespace App\Entity;

use App\Repository\employeeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: employeeRepository::class)]
class employeesdetails
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

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

    public function getsalary(): ?int
    {
        return $this->salary;
    }

    public function setsalary(int $salary): self
    {
        $this->salary = $salary;

        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destation;
    }

    public function setDestation(?string $destation): self
    {
        $this->destation = $destation;

        return $this;
    }
}
