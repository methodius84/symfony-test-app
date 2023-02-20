<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var string|null {headphones | case}
     */
    #[ORM\Column(length: 255)]
    private ?string $name = null;

//    #[ORM\Column]
//    private ?int $price = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\Regex(pattern: "/^[A-Z]{2}[0-9]+$/", message: 'Invalid tax number.', match: true)]
    private ?string $tax_number = null;

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

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTaxNumber(): ?string
    {
        return $this->tax_number;
    }

    /**
     * @param string|null $tax_number
     */
    public function setTaxNumber(?string $tax_number): void
    {
        $this->tax_number = $tax_number;
    }
}
