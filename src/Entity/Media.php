<?php

namespace App\Entity;

use App\Repository\MediaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MediaRepository::class)
 */
class Media
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
    private $url;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type_media;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $hash_filename;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getTypeMedia(): ?string
    {
        return $this->type_media;
    }

    public function setTypeMedia(?string $type_media): self
    {
        $this->type_media = $type_media;

        return $this;
    }

    public function getHashFilename(): ?string
    {
        return $this->hash_filename;
    }

    public function setHashFilename(string $hash_filename): self
    {
        $this->hash_filename = $hash_filename;

        return $this;
    }
}
