<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * A Plant
 */
#[ApiResource(mercure: true)]
#[ORM\Entity]
class Plant
{
    /**
     * The entity ID
     */
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private ?int $id = null;

    /**
     * The entity UUID
     * label pattern : YYYY_number
     * YYYY should be acquisition year
     */
    #[ORM\Column]
    private string $uuid = '';

    /**
     * Plant's variety
     */
    #[ORM\Column]
    #[Assert\NotBlank]
    public string $variety = '';

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     */
    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }
}
