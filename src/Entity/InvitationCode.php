<?php

namespace App\Entity;

use App\Repository\InvitationCodeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: InvitationCodeRepository::class)]
#[UniqueEntity(fields: ['code'], message: 'Le code d\'invitation est déjà utilisé')]
class InvitationCode
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 5)]
    private ?string $code;
    
    #[ORM\Column]
    private ?\DateTime $expire_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getExpireAt(): ?\DateTime
    {
        return $this->expire_at;
    }

    public function setExpireAt(\DateTime $expire_at): static
    {
        $this->expire_at = $expire_at;

        return $this;
    }
}
